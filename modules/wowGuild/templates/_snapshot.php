<table width="100%" cellspacing="4" cellpadding="0" border="0">
  <tbody>
    <?php foreach($wowClasses as $wowClass): ?>
    <tr class="<?php echo strtolower($wowClass->getShortName()); ?>">
      <td><img width="21" height="21" src="/cre8WowPlugin/images/class/21x21border/<?php echo $wowClass->getIcon(); ?>"/></td>
      <td><?php echo $wowClass->getName(); ?></td>
      <?php include_component('wowGuild', 'snapshotClassProfessions', array('guildId' => $guildId, 'classId' => $wowClass->getId())); ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>