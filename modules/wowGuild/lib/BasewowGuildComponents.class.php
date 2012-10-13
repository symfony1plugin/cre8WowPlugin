<?php

/**
 * Base components for the cre8WowPlugin wowGuild module.
 *
 * @package     cre8WowPlugin
 * @subpackage  wowGuild
 * @author      Bogumil Wrona <b.wrona@cre8newmedia.com>
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasewowGuildComponents extends sfComponents
{
  public function executeSnapshot(sfWebRequest $request) {
    $this->guild = WowGuildQuery::create()->filterByPrimaryKey($this->guild_id)->findOne();
    $this->wowClasses = WowClassQuery::create()->orderByName()->find();
  }

  public function executeSnapshotClassProfessions(sfWebRequest $request) {
    $this->wowClassSpecs = WowClassSpecQuery::create()
            ->filterByWowClassId($this->classId)
            ->orderByRank()
            ->find();
  }

  public function executeMembers(sfWebRequest $request) {

    $this->wowGuild = WowGuildQuery::create()->filterByPrimaryKey($this->guild_id)->findOne();
    $c = new Criteria();
    $c->addAscendingOrderByColumn(WowCharacterPeer::NAME);
    $this->wowGuildMembers = $this->wowGuild->getWowGuildMembersJoinWowCharacter($c);

  }

  public function executeMemberRow(sfWebRequest $request) {
    $wowGuildMember = WowGuildMemberQuery::create()
      ->filterByPrimaryKeyJoinWithAll($this->wow_character_id)
      ->findOne();

    $this->wowGuildMember = $wowGuildMember;
    $this->wowGuild = $wowGuildMember->getWowGuild();
    $this->wowCharacter = $wowGuildMember->getWowCharacter();
    $this->wowGuildRank = $wowGuildMember->getWowGuildRank();
    $this->wowZone = $this->wowCharacter->getWowZone();
    $this->wowRealm = $this->wowCharacter->getWowRealm();
    $this->wowFaction = $this->wowCharacter->getWowFaction();
    $this->wowRace = $this->wowCharacter->getWowRace();
    $this->wowClass = $this->wowCharacter->getWowClass();
    $this->wowGender = $this->wowCharacter->getWowGender();
    
    $this->wowClassSpec = $wowGuildMember->getWowGuildMemberRolesJoinWowClassSpec()->getFirst()->getWowClassSpec();
    $this->wowRaceGenderIcon = WowRaceGenderIconQuery::create()->filterByWowRace($this->wowRace)->filterByWowGender($this->wowGender)->findOne();
  }

  public function executeStats(sfWebRequest $request) {
    $this->wowGuild = WowGuildQuery::create()->filterByPrimaryKey($this->guild_id)->findOne();
    $this->wowRaces = WowRaceQuery::create()->filterByWowFactionId($this->wowGuild->getWowFactionId())->orderByName()->find();
    $this->wowClasses = WowClassQuery::create()->orderByName()->find();
    $this->icons = array();
    $racesPks = array();
    foreach($this->wowRaces as $wowRace) {
      $racesPks[] = $wowRace->getId();
    }
    foreach(WowRaceGenderIconQuery::create()->filterByWowRaceId($racesPks)->joinWith('WowRaceGenderIcon.WowRace')->orderBy('WowRace.Name')->find() as $wowRaceGenderIcon) {
      $this->icons[$wowRaceGenderIcon->getWowGenderId()][] = $wowRaceGenderIcon->getIcon();
    }    
  }

  public function executeSync(sfWebRequest $request) {
    
  }
  
}