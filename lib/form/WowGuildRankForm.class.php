<?php

/**
 * WowGuildRank form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class WowGuildRankForm extends BaseWowGuildRankForm
{
  public function configure()
  {
    if(!$this->isNew()) {
      unset($this['armory_id']);
    }
  }
}
