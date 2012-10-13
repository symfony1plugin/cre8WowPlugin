<?php


/**
 * Skeleton subclass for performing query and update operations on the 'wow_character_item_enchant' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.0-dev on:
 *
 * śro, 10 mar 2010, 00:31:24
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class WowCharacterItemEnchantQuery extends BaseWowCharacterItemEnchantQuery {

	/**
	 * Returns a new WowCharacterItemEnchantQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    WowCharacterItemEnchantQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof WowCharacterItemEnchantQuery) {
			return $criteria;
		}
		$query = new self();
		if (null !== $modelAlias) {
			$query->setModelalias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

} // WowCharacterItemEnchantQuery
