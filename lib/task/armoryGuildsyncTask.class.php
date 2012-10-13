<?php

class armoryGuildsyncTask extends sfBaseTask
{
  protected function configure()
  {
     // add your own arguments here
     $this->addArguments(array(
       new sfCommandArgument('zone', sfCommandArgument::REQUIRED, 'Zone [eu,us,kr, ...]'),
       new sfCommandArgument('realm', sfCommandArgument::REQUIRED, 'Realm name ["Kul Tiras", "Burning Legion", ...]'),
       new sfCommandArgument('name', sfCommandArgument::REQUIRED, 'Guild name ["Knights of Poland", Element, ...]')
     ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = 'armory';
    $this->name             = 'guild-sync';
    $this->briefDescription = 'Synchronise Guild with WoW Armory';
    $this->detailedDescription = <<<EOF
The [armory:guild-sync|INFO] task does things.
Call it with:

  [php symfony armory:guild-sync|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $armory = new cre8WowArmory($arguments['realm'], $arguments['zone']);
    $armoryGuild = $armory->getGuild($arguments['name']);
    if(!$armoryGuild) return;

    foreach($armoryGuild->getMembers() as $xmlMember) {
      $this->runTask('armory:character-import', array('zone' => $arguments['zone'], 'realm' => ("\"".$arguments['realm'] . "\""), 'characterName' => $xmlMember['name']));
//      sleep(1);
    }

  }
}
