<?php

/**
 * WowGuild form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class WowGuildForm extends BaseWowGuildForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at']
    );

    if(!$this->isNew()) {
      $this->embedRelation('WowGuildRank', array(
        'hide_on_new' => true,
        'add_empty' => false,
        'add_delete' => false
      ));
      $this->embedRelation('WowGuildMember', array());

    }
    
  }
}
