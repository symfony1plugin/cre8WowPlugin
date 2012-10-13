<?php


/**
 * Skeleton subclass for performing query and update operations on the 'wow_guild_member' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.0-dev on:
 *
 * sob, 6 mar 2010, 20:39:11
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class WowGuildMemberQuery extends BaseWowGuildMemberQuery {

	/**
	 * Returns a new WowGuildMemberQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    WowGuildMemberQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof WowGuildMemberQuery) {
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

  public function guildMembersBySpec($wowClassSpecId, $guildId)
  {
    return $this
      ->filterByWowGuildId($guildId)
      ->useWowCharacterQuery('c')
        ->useWowGuildMemberQuery('m')
          ->useWowGuildMemberRoleQuery('r')
            ->filterByWowClassSpecId($wowClassSpecId)
          ->endUse()
        ->endUse()
      ->endUse();
  }

  public function countGuildMembersBySpec($wowClassSpecId, $guildId)
  {
    return $this->guildMembersBySpec($wowClassSpecId, $guildId)->count();
  }

  public function filterByPrimaryKeyJoinWithAll($wow_character_id)
  {
    return $this->filterByWowCharacterId($wow_character_id)
      ->setFormatter(ModelCriteria::FORMAT_ON_DEMAND)
      ->joinWith('WowGuildMember.WowGuild')
      ->joinWith('WowGuildMember.WowCharacter')
      ->joinWith('WowGuildMember.WowGuildRank')
      ->joinWith('WowCharacter.WowZone')
      ->joinWith('WowCharacter.WowRealm')
      ->joinWith('WowCharacter.WowFaction')
      ->joinWith('WowCharacter.WowRace')
      ->joinWith('WowCharacter.WowClass')
      ->joinWith('WowCharacter.WowGender');
  }

  public function countGuildMembersByRace($wowRaceId, $guildId)
  {
    return $this->filterByWowGuildId($guildId)
            ->useWowCharacterQuery('c', Criteria::LEFT_JOIN)
              ->filterByWowRaceId($wowRaceId)
            ->endUse()
            ->count();
  }

  public function guildMembersByClass($wowClassId, $guildId)
  {
    return $this->filterByWowGuildId($guildId)
            ->useWowCharacterQuery('c', Criteria::LEFT_JOIN)
              ->filterByWowClassId($wowClassId)
            ->endUse();
  }

  public function countGuildMembersByClass($wowClassId, $guildId)
  {
    return $this->guildMembersByClass($wowClassId, $guildId)->count();
  }

  public function countGuildMembersByGender($wow_gender_id, $guildId)
  {
    return $this->filterByWowGuildId($guildId)
            ->useWowCharacterQuery('c', Criteria::LEFT_JOIN)
              ->filterByWowGenderId($wow_gender_id)
            ->endUse()
            ->count();
  }

  public function getWowCharacterObject() {
    return $this->joinWith('WowGuildMember.WowCharacter');
  }

  public function sortByWowCharacterName() {
    return $this->useWowCharacterQuery()->orderByName()->endUse();
  }

  

} // WowGuildMemberQuery