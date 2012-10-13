<?php

/**
 * WowCharacterItem form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class WowCharacterItemForm extends BaseWowCharacterItemForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at']
    );

    $this->embedRelation('WowCharacterItemGem', array());
    $this->embedRelation('WowCharacterItemEnchant', array());

  }
}
