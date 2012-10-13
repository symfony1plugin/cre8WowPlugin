<?php use_helper('cre8Wow'); ?>
<?php use_stylesheet('/cre8WowPlugin/css/common.css'); ?>
<?php use_stylesheet('/cre8WowPlugin/css/boxStats.css'); ?>

<div class="guid_content">

  <div class="stats_holder line_top">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td class="stats_header" colspan="<?php echo $wowRaces->count(); ?>">Race Breakdown</td>
        </tr>
        <tr class="blue">
          <?php foreach($wowRaces as $wowRace): ?>
          <td class="stats_herb"><?php echo $wowRace; ?></td>
          <?php endforeach; ?>
        </tr>
        <tr class="stats_class_img">
          <?php foreach($wowRaces as $wowRace): ?>
          <td>
            <?php echo image_tag('/cre8WowPlugin/images/coat/race/127x158/' . $wowRace->getCoat(), array('alt_title' => $wowRace->getName())); ?>
          </td>
          <?php endforeach; ?>
        </tr>
        <tr class="stats_herb">
          <?php foreach($wowRaces as $wowRace): ?>
          <td class="stats_herbNum"><?php echo WowGuildMemberQuery::create()->countGuildMembersByRace($wowRace->getId(), $wowGuild->getId()); ?></td>
          <?php endforeach; ?>
        </tr>
      </tbody>
    </table>


  </div>

  <div class="stats_holder line_top">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
          <td class="stats_header" colspan="<?php echo $wowClasses->count(); ?>">Class Breakdown</td>
        </tr>
        <tr class="stats_class_img">
          <?php foreach($wowClasses as $wowClass): ?>
          <td>
            <?php echo image_tag('/cre8WowPlugin/images/class/47x47/' . $wowClass->getIcon(), array('alt_title' => $wowClass->getName())); ?>
          </td>
          <?php endforeach; ?>
        </tr>
        <tr>
          <?php foreach($wowClasses as $wowClass): ?>
          <td class="stats_classNum"><?php echo WowGuildMemberQuery::create()->countGuildMembersByClass($wowClass->getId(), $wowGuild->getId()); ?></td>
          <?php endforeach; ?>
        </tr>
      </tbody>
    </table>
  </div>


  <div class="stats_holder line_top">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
          <td class="stats_header" colspan="3">Gender Breakdown</td>
        </tr>
        <tr>
          <td class="stats_sex_img">
            <?php if(isset($icons[2])): foreach($icons[2] as $icon): ?>
            <img width="21" height="21" src="/cre8WowPlugin/images/race_gender/21x21/<?php echo $icon; ?>">
            <?php endforeach; endif; ?>
          </td>
          <td>&nbsp;</td>
          <td class="stats_sex_img">
            <?php if(isset($icons[1])): foreach($icons[1] as $icon): ?>
            <img width="21" height="21" src="/cre8WowPlugin/images/race_gender/21x21/<?php echo $icon; ?>">
            <?php endforeach; endif; ?>
          </td>
        </tr>
        <tr>

          <td class="stats_classNum"><?php echo WowGuildMemberQuery::create()->countGuildMembersByGender(2, $wowGuild->getId()); ?></td>
          <td>&nbsp;</td>
          <td class="stats_classNum"><?php echo WowGuildMemberQuery::create()->countGuildMembersByGender(1, $wowGuild->getId()); ?></td>

        </tr>


      </tbody>
    </table>



  </div>

</div>