<?php use_helper('cre8Wow'); ?>

<div class="character_part_1">
  <div class="character_icon_column">
    <table width="100%" cellspacing="5" cellpadding="0" border="0">
      <tbody><tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(0)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(1)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(2)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(14)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(4)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(3)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(18)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(8)); ?></td>
        </tr>
      </tbody></table>
  </div>

  <div class="character_img_part">

    <div class="character_ifrems">
      <iframe width="321" scrolling="no" height="440" frameborder="0" src="http://<?php echo ( (($zone = $wowCharacter->getWowZone()->getName()) != 'US') ? strtolower($zone) : 'www'); ?>.wowarmory.com/character-model-embed.xml?r=<?php echo urlencode($wowCharacter->getWowRealm()->getName()); ?>&amp;cn=<?php echo $wowCharacter->getName(); ?>&amp;rhtml=true" style="background-color: rgb(0, 0, 0);"></iframe>
    </div>

    <div class="character_icon_row_holder">
      <div class="character_icon_row">
        <table width="100%" cellspacing="6" cellpadding="0" border="0">
          <tbody><tr>
              <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemByName('MainHand')); ?></td>
              <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemByName('OffHand')); ?></td>
              <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemByName('CustomWeapon')); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <div class="character_icon_column">
    <table width="100%" cellspacing="5" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(9)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(5)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(6)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(7)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(10)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(11)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(12)); ?></td>
        </tr>
        <tr>
          <td><?php echo renderWowCharacterItem($sf_data->getRaw('wowCharacter')->getWowCharacterItemBySlot(13)); ?></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>




<!-- DETAILED ITEMS LIST START -->
<div class="character_part_gearScore">
  <div class="gear_show" ><span class="hidden" id="character_gear_show"><span id="openStatus">Pokaz</span> Gear List</span></div>

  <div class="character_part_2" id="character_gear_content" style="display: none;">
    <table width="100%" cellspacing="1" cellpadding="0" border="0">
      <tbody>
        <tr class="table_header blue">
          <td colspan="2">Item Name</td>
          <td>Level</td>
          <td>Gems</td>
          <td>Enchant</td>
        </tr>
        <?php foreach($sf_data->getRaw('wowCharacter')->getItemsOrderedByRank() as $wowCharacterItem): ?>
        <tr class="gear_row ">
          <td class="table_img"><?php echo linkToWowHeadItem($wowCharacterItem->getWowItem(), 'img', '21x21'); ?></td>
          <td class="gear_name"><?php echo linkToWowHeadItem($wowCharacterItem->getWowItem(), 'txt'); ?></td>
          <td class="gear_level"><?php echo $wowCharacterItem->getWowItem()->getLevel(); ?></td>
          <td class="gear_gems">
              <?php foreach($wowCharacterItem->getWowCharacterItemGemsJoinWowItem() as $wowCharacterItemGem): ?>
                <?php echo linkToWowHeadItem($wowCharacterItemGem->getWowItem(), 'img', '21x21'); ?>
              <?php endforeach; ?>
          </td>
          <td class="gear_enchant">
              <?php foreach($wowCharacterItem->getWowCharacterItemEnchantsJoinWowItem() as $wowCharacterItemEnchant): ?>
                <?php echo linkToWowHeadItem($wowCharacterItemEnchant->getWowItem(), 'img', '21x21'); ?>
              <?php endforeach; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<!-- DETAILED ITEMS LIST END -->





<div class="character_part_1a line_top">
  <div class="character_info_part">
    <table width="100%" cellspacing="4" cellpadding="0" border="0">
      <tbody>

        <?php if($wowCharacter->countWowGuildMembers()): ?>
        <tr>
          <td class="character_info_part_1a">Ranga:</td>
          <td class="character_info_part_1b"></td>
          <td class="character_info_part_rank"><?php echo WowGuildRankQuery::create()->useWowGuildMemberQuery()->filterByWowCharacter($wowCharacter)->endUse()->findOne()->getName(); ?></td>
        </tr>
        <?php endif; ?>

        <tr>
          <td class="character_info_part_1a">Klasa:</td>
          <td class="character_info_part_1b"><img width="21" height="21" src="/cre8WowPlugin/images/class/21x21border/<?php echo $wowCharacter->getWowClass()->getIcon(); ?>"></td>
          <td class="character_info_part_1c"><?php echo $wowCharacter->getWowClass(); ?></td>
        </tr>

        <?php if($wowCharacter->countWowGuildMembers()): ?>

          <?php foreach(WowGuildMemberRoleQuery::create()->useWowGuildMemberQuery()->filterByWowCharacter($wowCharacter)->endUse()->joinWith('WowGuildMemberRole.WowClassSpec')->find() as $wowGuildMemberRole): ?>
        <tr>
          <td class="character_info_part_1a">Rola w gildi:</td>
          <td class="character_info_part_1b"><img width="21" height="21" src="/cre8WowPlugin/images/spec/21x21border/<?php echo $wowGuildMemberRole->getWowClassSpec()->getIcon(); ?>"></td>
          <td class="character_info_part_1c"><?php echo $wowGuildMemberRole->getWowClassSpec(); ?></td>
        </tr>
          <?php endforeach; ?>

        <?php else: ?>
          <?php foreach($wowCharacter->getWowCharacterClassSpecsJoinWowClassSpec() as $wowCharacterClassSpec): ?>
        <tr>
          <td class="character_info_part_1a"><?php echo $wowCharacterClassSpec->isActive() ? 'Main Spec' : 'Off Spec'; ?></td>
          <td class="character_info_part_1b"><img width="21" height="21" src="/cre8WowPlugin/images/spec/21x21border/<?php echo $wowCharacterClassSpec->getWowClassSpec()->getIcon(); ?>"></td>
          <td class="character_info_part_1c"><?php echo $wowCharacterClassSpec->getWowClassSpec(); ?></td>
        </tr>
          <?php endforeach; ?>

        <?php endif; ?>

        <tr>
          <td class="character_info_part_1a">Rasa:</td>
          <td class="character_info_part_1b"><img width="21" height="21" src="/cre8WowPlugin/images/race_gender/21x21/<?php echo WowRaceGenderIconQuery::create()->filterByWowGenderId($wowCharacter->getWowGenderId())->filterByWowRaceId($wowCharacter->getWowRaceId())->findOne()->getIcon(); ?>"></td>
          <td class="character_info_part_1c"><?php echo $wowCharacter->getWowRace(); ?></td>
        </tr>
      </tbody></table>

  </div>
  <div class="character_info_part">
    <table width="100%" cellspacing="4" cellpadding="0" border="0">
      <tbody>


        <tr>
          <td class="character_info_part_1a">Profesje:</td>
          <td class="character_info_part_1d">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <?php foreach($wowCharacter->getWowCharacterProfessionsJoinWowProfession() as $wowCharacterProfession): ?>
                <tr>
                  <td class="character_info_part_1b"><?php echo image_tag('/cre8WowPlugin/images/profession/21x21/' . $wowCharacterProfession->getWowProfession()->getIcon(), array('alt_title' => $wowCharacterProfession->getWowProfession()->getName())); ?></td>
                  <td class="character_info_part_1c"><?php echo $wowCharacterProfession->getWowProfession(); ?> (<?php echo $wowCharacterProfession->getLevel(); ?>)</td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </td>
        </tr>


        <tr>
          <td class="character_info_part_1a">Achievement Poins:</td>
          <td class="character_info_part_1d">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td class="character_info_part_1b">&nbsp;</td>
                  <td class="character_info_part_1c"><?php echo $wowCharacter->getAchievementPoints(); ?></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>

  </div>
</div>

