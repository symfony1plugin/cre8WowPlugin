<?php

/**
 * WowCharacter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class WowCharacterForm extends BaseWowCharacterForm
{
  public function configure()
  {
    unset($this['sf_guard_user_wow_character_list'], $this['source']);
    $this->embedRelation('WowCharacterProfession', array());
  }
}
