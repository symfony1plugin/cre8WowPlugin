<?php

/**
 * WowClass form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class PluginWowClassForm extends BaseWowClassForm
{
  public function configure()
  {
    if(isset($this['wow_item_class_list'])) {
      unset($this['wow_item_class_list']);
    }    

    if(!$this->isNew()) {
      unset($this['armory_id'], $this['short_name']);
    }

    $this->setWidget('icon', new sfWidgetFormInputFileEditable(array(
      'file_src' => '/cre8WowPlugin/images/class/47x47/' . $this->getObject()->getIcon(),
      'is_image' => true,
      'edit_mode' => !$this->isNew(),
      'with_delete' => false,
      'template' => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>'
    )));
    $this->setValidator('icon', new sfValidatorFile(array(
      'required' => $this->isNew(),
      'path' => sfConfig::get('sf_web_dir') . '/cre8WowPlugin/images/class/47x47',
      'mime_types' => 'web_images'
    )));

  }
}
