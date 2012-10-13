<?php

require_once dirname(__FILE__).'/../lib/BasewowAjaxActions.class.php';

/**
 * wowAjax actions.
 * 
 * @package    cre8WowPlugin
 * @subpackage wowAjax
 * @author     Bogumil Wrona <b.wrona@cre8newmedia.com>
 * @version    SVN: $Id: actions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class wowAjaxActions extends BasewowAjaxActions
{
  public function executeCharacterImport(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $task = new armoryCharacterimportTask(sfContext::getInstance()->getEventDispatcher(), new sfFormatter());
    $arguments = array(
      'zone' => $wowZoneName,
      'realm' => "\"".$wowRealmName ."\"",
      'characterName' => $characterName
    );
    // type can be one of: i18n, routing, template, module, config
    $options = array(
      'env'  => sfConfig::get('sf_environment', 'dev'),
      'application' => 'frontend',
      'connection' => 'propel'
    );
    chdir(sfConfig::get('sf_root_dir'));
    return $this->renderText(!$task->run($arguments, $options));
  }

}
