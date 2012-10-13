<table style="background-color: #1C1C1E;" id="myTable" width="100%" cellspacing="1" cellpadding="0" border="0" class="knight_table tablesorter">
  <thead>
    <tr class="table_header blue">
      <th>Nazwa</th>
      <th>Ranga</th>
      <th>Status</th>
      <th>ACTION</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($sf_data->getRaw('armoryGuild')->getMembers() as $xmlMember): ?>
    <tr class="knight_row armory_class_<?php echo $xmlMember['classId'] ?>">
      <td class="knight_nick"><?php echo $xmlMember['name']; ?></td>
      <td class="knight_rank"><?php echo $xmlMember['rank']; ?></td>
      <td class="knight_rank">STATUS</td>
      <td class="knight_rank">ACTIONS</td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>