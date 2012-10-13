<?php

/**
 * WowClass filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
class WowClassFormFilter extends BaseWowClassFormFilter
{
  public function configure()
  {
    $this->useFields(array('name', 'armory_id', 'short_name'), true);
  }
}
