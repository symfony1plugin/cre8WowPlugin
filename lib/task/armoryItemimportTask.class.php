<?php

class armoryItemimportTask extends sfBaseTask
{
  protected function configure()
  {
     // add your own arguments here
     $this->addArguments(array(
       new sfCommandArgument('zone', sfCommandArgument::REQUIRED, 'Zone [eu,us,kr, ...]'),
       new sfCommandArgument('ID', sfCommandArgument::REQUIRED, 'ID of the item (number)')
     ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      // add your own options here
    ));

    $this->namespace        = 'armory';
    $this->name             = 'item-import';
    $this->briefDescription = 'Imports selected item from WoW Armory to local database';
    $this->detailedDescription = <<<EOF
The [armory:item-import|INFO] task does things.
Call it with:

  [php symfony armory:item-import|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    try {
      $connection->beginTransaction();
      
      $armory = new cre8WowArmory('', $arguments['zone']);
      $armoryItem = $armory->getItem($arguments['ID']);
      if(!$armoryItem) return;

      $wowItem = WowItemQuery::create()
              ->filterByPrimaryKey($arguments['ID'])
              ->findOne();
      if(!$wowItem) {
        $wowItem = new WowItem();
      }

      $this->dispatcher->notify(new sfEvent($this, 'task.item.import.start', array('wowItem' => $wowItem, 'wowArmory' => $armory)));
      
      $wowItem->setId($armoryItem->getId());
      $wowItem->setName($armoryItem->getName());
      $wowItem->setIcon($armoryItem->getIcon());
      $wowItem->setLevel($armoryItem->getLevel());
      $wowItem->setQuality($armoryItem->getQuality());
      $wowItem->setArmoryType($armoryItem->getType());
      $wowItem->setSource($armoryItem->getXML());
      $wowItem->save();

      $connection->commit();
      $this->dispatcher->notify(new sfEvent($this, 'task.item.import.finish', array('wowItem' => $wowItem, 'wowArmory' => $armory)));
      
    } catch(Exception $e) {
      $connection->rollback();
      $this->logSection('ERROR with item ID: ' . $arguments['ID'], 'Error occured. Item NOT imported/synchronised.');
      throw $e;
    }

//    $this->logSection($wowItem->getName(), 'Item synchronisation with WoW Armory finished');

  }
}
