<?php use_helper('Date'); ?>
<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <?php foreach($sf_data->getRaw('feed')->getItems() as $item): ?>
  <tr>
    <td class="activity_icon"><img  src="/images/feed_icon_bosskill.png" width="35" height="35"></td>
    <td class="activity_content">
      <span class="activity_des"><?php echo $item->getContent(); ?></span>
      <span class="timestamp"> <?php echo time_ago_in_words($item->getPubDate()) ?> ago</span>
    </td>
  </tr>
  <?php endforeach; ?>

</table>