<?php

/**
 * Base components for the cre8WowPlugin wowGuild module.
 *
 * @package     cre8WowPlugin
 * @subpackage  wowGuild
 * @author      Bogumil Wrona <b.wrona@cre8newmedia.com>
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BasewowCharacterComponents extends sfComponents
{
  public function executeMainView(sfWebRequest $request)
  {
    $this->wowCharacter = WowCharacterQuery::create()->filterByPrimaryKeyJoinWithAll($this->wow_character_id)->findOne();

  }

  public function executeRssFeeds(sfWebRequest $request)
  {
    $wowCharacter = WowCharacterQuery::create()->filterByPrimaryKeyJoinWithAll($this->wow_character_id)->findOne();
    $cre8WowArmory = new cre8WowArmory($wowCharacter->getWowRealm()->getName(), strtolower($wowCharacter->getWowZone()->getName()));
    $feedUrl = $cre8WowArmory->getUrl('character-feed.atom?r=' . urlencode($wowCharacter->getWowRealm()->getName()) . '&cn=' . $wowCharacter->getName() . '&filters=BOSSKILL,LOOT,RESPEC&itemLevel=200&locale=en_GB');
    $feed = sfFeedPeer::createFromWeb($feedUrl);
    $this->feed = sfFeedPeer::aggregate(array($feed));
    
  }

}