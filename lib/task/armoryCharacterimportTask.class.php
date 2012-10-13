<?php

class armoryCharacterimportTask extends sfBaseTask
{
  /**
   *
   * @var mixed A Database instance
   */
  protected $connection = null;

  /**
   *
   * @var WowZone WoWZone instance object or null
   */
  protected $wowZone = null;

  /**
   *
   * @var WowRealm
   */
  protected $wowRealm = null;

  /**
   *
   * @var WowGuild 
   */
  protected $wowGuild = null;

  protected $isNew = false;

  protected $commandArguments = array();
  protected $commandOptions = array();

  protected function configure()
  {
     // add your own arguments here
     $this->addArguments(array(
       new sfCommandArgument('zone', sfCommandArgument::REQUIRED, 'Zone [eu,us,kr, ...]'),
       new sfCommandArgument('realm', sfCommandArgument::REQUIRED, 'Realm name ["Kul Tiras", "Burning Legion", ...]'),
       new sfCommandArgument('characterName', sfCommandArgument::REQUIRED, 'Character name')
     ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = 'armory';
    $this->name             = 'character-import';
    $this->briefDescription = 'Imports selected character from WoW Armory to local database.';
    $this->detailedDescription = <<<EOF
The [armory:character-import|INFO] task does things.
Call it with:

  [php symfony armory:character-import|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->commandArguments = $arguments;
    $this->commandOptions = $options;
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $this->connection = $connection;

    $armory = new cre8WowArmory($arguments['realm'], $arguments['zone']);
    $armoryCharacter = $armory->getCharacter($arguments['characterName']);
    if(!$armoryCharacter) {
      $this->logSection($arguments['characterName'], 'Character does not exists.');
      return 1;
    }
//    $this->logSection($arguments['characterName'], 'Character found in Armory.');
    if(!$this->wowZone = WowZoneQuery::create()->filterByName($arguments['zone'])->findOne()) {
      $this->wowZone = new WowZone();
      $this->wowZone->setName($arguments['zone']);
      $this->wowZone->save($connection);
    }

    if(!$this->wowRealm = WowRealmQuery::create()->filterByName($arguments['realm'])->findOne()) {
      $this->wowRealm = new WowRealm();
      $this->wowRealm->setName($arguments['realm']);
      $this->wowRealm->setWowZone($this->getWowZone());
      $this->wowRealm->save($connection);
    }

    $wowCharacter = WowCharacterQuery::create()
            ->filterByArmory($armory, $arguments['characterName'])
            ->findOne($connection);
    if(!$wowCharacter) {
      $wowCharacter = new WowCharacter();
      $this->isNew = true;
//      $this->logSection($arguments['characterName'], 'Character created locally.');
    } else {
//      $this->logSection($arguments['characterName'], 'Character loaded from local database. WowCharacter.ID: ' . $wowCharacter->getId());
    }

    try {
      $connection->beginTransaction();
      $this->dispatcher->notify(new sfEvent($this, 'task.character.import.start', array('wowCharacter' => $wowCharacter, 'wowArmory' => $armory)));
      
      $wowCharacter->setWowZone($this->getWowZone());
      $wowCharacter->setWowRealm($this->getWowRealm());
      $wowCharacter->setWowFaction(WowFactionQuery::create()->filterByArmoryId($armoryCharacter->getFactionId())->findOne());
      $wowCharacter->setWowRace(WowRaceQuery::create()->filterByArmoryId($armoryCharacter->getRaceId())->findOne());
      $wowCharacter->setWowClass(WowClassQuery::create()->filterByArmoryId($armoryCharacter->getClassId())->findOne());
      $wowCharacter->setWowGender(WowGenderQuery::create()->filterByArmoryId($armoryCharacter->getGenderId())->findOne());
      $wowCharacter->setName($armoryCharacter->getName());
      $wowCharacter->setLevel($armoryCharacter->getLevel());
      $wowCharacter->setAchievementPoints($armoryCharacter->getAchievementPoints());

      if($wowCharacter->isNew()) {
        $primarySpec = $armoryCharacter->getPrimarySpec();
        $mainSpec = $wowCharacter->setClassSpecByArmory($primarySpec);
        $secondarySpec = $armoryCharacter->getSecondarySpec();
        if($secondarySpec && ($primarySpec !== $secondarySpec) && $secondarySpec['mainTree'] ) {
          $offSpec = $wowCharacter->setClassSpecByArmory($secondarySpec);
        }
      }

      $wowCharacter->setSource($armoryCharacter->getXML());

      $wowCharacter->save($connection);

      if($guildName = $armoryCharacter->getGuildName()) {
        $this->wowGuild = WowGuildQuery::create()->filterByArmory($this->getWowZone(), $this->getWowRealm())->filterByName($guildName)->findOne();
        if(!$this->wowGuild) {
          $this->wowGuild = new WowGuild();
          $this->wowGuild->setWowZone($this->getWowZone());
          $this->wowGuild->setWowRealm($this->getWowRealm());
          $wowFaction = WowFactionQuery::create()->filterByArmoryId($armoryCharacter->getFactionId())->findOne();
          $this->wowGuild->setWowFaction($wowFaction);
          $this->wowGuild->setName($guildName);
          $this->wowGuild->save($connection);
          $this->logSection('Guild', '"' . $this->wowGuild->getName() . '"' .' created locally.');
        }
        if(!$wowGuildMember = WowGuildMemberQuery::create()
                ->filterByWowGuild($this->wowGuild)
                ->filterByWowCharacter($wowCharacter)
                ->findOne()
        ) {
          foreach($wowCharacter->getWowGuildMembers() as $oldWowGuildMember) {
            $oldWowGuildMember->delete();
          }
          $wowGuildMember = new WowGuildMember();
          $this->logSection($arguments['characterName'], 'Linking with: "' . $this->wowGuild->getName() . '" guild.');
        }

        if($armoryGuild = $armory->getGuild($armoryCharacter->getGuildName())) {
          $characterRankInGuild = ($rank = $armoryGuild->getCharacterRank($wowCharacter->getName())) ? $rank : 8;
        } else {
          $characterRankInGuild = 8;
        }

        $wowGuildMember->setWowGuild($this->wowGuild);
        $wowGuildMember->setWowCharacter($wowCharacter);
        $wowGuildMember->setWowGuildRank(WowGuildRankQuery::create()->filterByArmoryId($characterRankInGuild)->findOne());
        $wowGuildMember->save($connection);

        if($this->isNew() && isset($mainSpec)) {
          $wowGuildMemberMainSpecRole = new WowGuildMemberRole();
          $wowGuildMemberMainSpecRole->setWowGuildMember($wowGuildMember);
          $wowGuildMemberMainSpecRole->setWowClassSpec($mainSpec->getWowClassSpec());
          $wowGuildMemberMainSpecRole->save();
          $this->logSection($arguments['characterName'], 'Added Main Spec Role: ' . $mainSpec->getWowClassSpec()->getName());
        }

      }

//      $this->logSection($arguments['characterName'], 'Delete all links between selected user and items.');
      foreach($wowCharacter->getWowCharacterItemsJoinWowItem() as $wowCharacterItem) {
//        $this->logSection($arguments['characterName'] . ' -> ' . $wowCharacterItem->getWowItem()->getName(), 'Unlinked successfully.');
        $wowCharacterItem->delete();
      }
      
      foreach($armoryCharacter->getItems() as $slot => $item) {

        if(!$wowItem = WowItemQuery::create()->filterByPrimaryKey($item['id'])->findOne($connection)) {
          $this->importItem($item['id']);
          $wowItem = WowItemQuery::create()->filterByPrimaryKey($item['id'])->findOne($connection);
          $this->logSection($arguments['characterName'] . ' -> ' . $wowItem->getName(), 'Linking using fresh data. Item ID: ' . $wowItem->getId());
        } else {
          $this->logSection($arguments['characterName'] . ' -> ' . $wowItem->getName(), 'Linking using local data. Item ID: ' . $wowItem->getId());
        }
        $wowCharacterItem = new WowCharacterItem();
        $wowCharacterItem->setWowCharacter($wowCharacter);
        $wowCharacterItem->setWowItemId($item['id']);
        $wowCharacterItem->setSlot($slot);
        $wowCharacterItem->save($connection);

        // GEMS:
        foreach($wowCharacterItem->getWowCharacterItemGems() as $wowCharacterItemGem) {
          $wowCharacterItemGem->delete();
        }
        foreach($item['gems'] as $gem) {
          if(!$wowGemItem = WowItemQuery::create()->filterByPrimaryKey($gem['id'])->findOne($connection)) {
            $this->importItem($gem['id']);
//            $this->logSection($arguments['characterName'] . ' -> ' . 'Item ID: ' . $item['id'], 'Linking using fresh data.');
          } else {
//            $this->logSection($arguments['characterName'] . ' -> ' . $wowItem->getName(), 'Linking using local data. Item ID: ' . $wowItem->getId());
          }
          $wowCharacterItemGem = new WowCharacterItemGem();
          $wowCharacterItemGem->setWowItemId($gem['id']);
          $wowCharacterItemGem->setWowCharacterItem($wowCharacterItem);
          $wowCharacterItemGem->save($connection);
          unset(
            $wowCharacterItemGem,
            $gem
          );
        }
        unset($slot);

        // ENCHANTS:
        foreach($wowCharacterItem->getWowCharacterItemEnchants() as $wowCharacterItemEnchant) {
          $wowCharacterItemEnchant->delete();
          unset($wowCharacterItemEnchant);
        }
        foreach($item['enchants'] as $enchant) {
          if(!$wowEnchantItem = WowItemQuery::create()->filterByPrimaryKey($enchant['id'])->findOne($connection)) {
            $this->importItem($enchant['id']);
//            $this->logSection($arguments['characterName'] . ' -> ' . 'Item ID: ' . $enchant['id'], 'Linking using fresh data.');
          }
          $wowCharacterItemEnchant = new WowCharacterItemEnchant();
          $wowCharacterItemEnchant->setWowCharacterItem($wowCharacterItem);
          $wowCharacterItemEnchant->setWowItemId($enchant['id']);
          $wowCharacterItemEnchant->save($connection);
          unset($wowCharacterItemEnchant);
        }
      }

      // PROFESSIONS:
      foreach($wowCharacter->getWowCharacterProfessions() as $wowCharacterProfession) {
        $wowCharacterProfession->delete();
        unset ($wowCharacterProfession);
      }
      foreach($armoryCharacter->getProfessions() as $profession) {
        $wowCharacterProfession = new WowCharacterProfession();
        $wowCharacterProfession->setWowCharacter($wowCharacter);
        $wowCharacterProfession->setWowProfessionId($profession['id']);
        $wowCharacterProfession->setLevel($profession['value']);
        $wowCharacterProfession->save($connection);
        unset($wowCharacterProfession);
      }
      
      $connection->commit();
      $this->dispatcher->notify(new sfEvent($this, 'task.character.import.finish', array('wowCharacter' => $wowCharacter, 'wowArmory' => $armory)));
      $this->logSection($arguments['characterName'], 'Character imported/synchronised successfully.');
      // cleaning:
      unset(
        $wowCharacter,
        $armoryCharacter,
        $armory
      );
    } catch (Exception $e) {
      $connection->rollback();
      $this->logSection('ERROR ' . $arguments['characterName'], 'Error occured. Character NOT imported/synchronised.');
      throw $e;
    }
  }

  public function getConnection() {
    return $this->connection;
  }

  public function getWowZone() {
    return $this->wowZone;
  }

  public function getWowRealm() {
    return $this->wowRealm;
  }

  public function isNew() {
    return $this->isNew ? true : false;
  }

  private function getOption($name) {
    return isset($this->commandOptions[$name]) ? $this->commandOptions[$name] : null;
  }

  private function getArgument($name) {
    return isset($this->commandArguments[$name]) ? $this->commandArguments[$name] : null;
  }

  protected function importItem($itemId) {
    chdir(sfConfig::get('sf_root_dir'));
    $itemImportTask = new armoryItemimportTask($this->dispatcher, $this->formatter);
    return $itemImportTask->run(array('zone' => $this->getArgument('zone'), 'ID' => $itemId), array('env' => $this->getOption('env'), 'application' => $this->getOption('application'), 'connection' => $this->getOption('connection')));
  }

}
