<?php

class cre8WowListener
{
  static public function listenToCharacterImportTaskStartEvent(sfEvent $event) {
    $parameters = $event->getParameters();
    
    $armoryCharacterImportTask = $event->getSubject();
    $wowCharacter = $parameters['wowCharacter'];
    $wowArmory = $parameters['wowArmory'];
    
  }

  static public function listenToCharacterImportTaskFinishEvent(sfEvent $event) {
    $parameters = $event->getParameters();
    
    $armoryCharacterImportTask = $event->getSubject();
    $wowCharacter = $parameters['wowCharacter'];
    $wowArmory = $parameters['wowArmory'];
    
  }

  static public function listenToItemImportTaskStartEvent(sfEvent $event) {
    $parameters = $event->getParameters();

    $armoryItemImportTask = $event->getSubject();
    $wowItem = $parameters['wowItem'];
    $wowArmory = $parameters['wowArmory'];

  }
  static public function listenToItemImportTaskFinishEvent(sfEvent $event) {

    $parameters = $event->getParameters();

    $armoryItemImportTask = $event->getSubject();
    $wowItem = $parameters['wowItem'];
    $wowArmory = $parameters['wowArmory'];

  }

}