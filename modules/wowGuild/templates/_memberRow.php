<tr class="knight_row <?php echo strtolower($wowClass->getShortName()); ?>">
  <td class="knight_nick"><?php echo $wowCharacter; ?></td>
  <td class="table_img"><?php echo image_tag('/cre8WowPlugin/images/class/21x21border/' . $wowClass->getIcon(), array()); ?></td>
  <td class="knight_klasa"><?php echo $wowClass; ?></td>
  <td class="table_img"><img width="21" height="21" src="/cre8WowPlugin/images/spec/21x21border/<?php echo $wowClassSpec->getIcon(); ?>"></td>
  <td class="knight_spec"><?php echo $wowClassSpec; ?></td>
  <td class="table_img"><img width="21" height="21" src="/cre8WowPlugin/images/race_gender/21x21/<?php echo $wowRaceGenderIcon->getIcon(); ?>"></td>
  <td class="knight_rasa"><?php echo $wowRace; ?></td>
  <td class="knight_rank"><?php echo $wowGuildRank; ?></td>
  <td class="knight_look"><a href="<?php echo url_for('wowCharacter', $wowCharacter); ?>"></a></td>
</tr>