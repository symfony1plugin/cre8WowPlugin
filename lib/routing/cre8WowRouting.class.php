<?php

class cre8WowRouting
{

 /**
 * Routing event listener for 'wowCharacter' module
 *
 * It's usefull to deal with restrictive routing configuration (with no `:module/:action` route enabled)
 *
 * @author Bogumil Wrona <b.wrona@cre8newmedia.com>
 * @package cre8WowPlugin
 * @subpackage routing
 */
  public static function listenToLoadConfigurationEvent_WowCharacterModule(sfEvent $event)
  {
    $routing = $event->getSubject();
    
  }

  /**
 * Routing event listener for 'wowGuild' module
 *
 * It's usefull to deal with restrictive routing configuration (with no `:module/:action` route enabled)
 *
 * @author Bogumil Wrona <b.wrona@cre8newmedia.com>
 * @package cre8WowPlugin
 * @subpackage routing
 */
  public static function listenToLoadConfigurationEvent_WowGuildModule(sfEvent $event)
  {
    $routing = $event->getSubject();
    
  }

}