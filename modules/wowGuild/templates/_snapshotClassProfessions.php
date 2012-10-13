<?php foreach($wowClassSpecs as $wowClassSpec): ?>
<td class="klasa_num"><img width="21" height="21" src="/cre8WowPlugin/images/spec/21x21/<?php echo $wowClassSpec->getIcon(); ?>"/><?php echo WowGuildMemberQuery::create()->countGuildMembersBySpec($wowClassSpec->getId(), $guildId); ?></td>
<?php endforeach; ?>
