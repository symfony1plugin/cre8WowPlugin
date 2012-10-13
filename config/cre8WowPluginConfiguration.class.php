<?php

/**
 * cre8WowPlugin configuration.
 * 
 * @package     cre8WowPlugin
 * @subpackage  config
 * @author      Bogumil Wrona <b.wrona@cre8newmedia.com>
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class cre8WowPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0-DEV';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('task.character.import.start', array('cre8WowListener', 'listenToCharacterImportTaskStartEvent'));
    $this->dispatcher->connect('task.character.import.finish', array('cre8WowListener', 'listenToCharacterImportTaskFinishEvent'));

    $this->dispatcher->connect('task.item.import.start', array('cre8WowListener', 'listenToItemImportTaskStartEvent'));
    $this->dispatcher->connect('task.item.import.finish', array('cre8WowListener', 'listenToItemImportTaskFinishEvent'));

    if (sfConfig::get('app_cre8_menu_plugin_routes_register', true))
    {
      if(in_array('wowCharacter', sfConfig::get('sf_enabled_modules', array()))) {
        $this->dispatcher->connect('routing.load_configuration', array('cre8WowRouting', 'listenToLoadConfigurationEvent_WowCharacterModule'));
      }

      if(in_array('wowGuild', sfConfig::get('sf_enabled_modules', array()))) {
        $this->dispatcher->connect('routing.load_configuration', array('cre8WowRouting', 'listenToLoadConfigurationEvent_WowGuildModule'));
      }
    }

  }
}
