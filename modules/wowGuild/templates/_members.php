<table id="myTable" width="100%" cellspacing="1" cellpadding="0" border="0" class="knight_table tablesorter">
  <thead>
    <tr class="table_header blue">
      <th>
        Nazwa
      </th>
      <th>
        &nbsp;
      </th>
      <th>
        Klasa
      </th>
      <th>
        &nbsp;
      </th>
      <th>
        Main Spec
      </th>
      <th>
        &nbsp;
      </th>
      <th>
        Rasa
      </th>
      <th>
        Ranga
      </th>
      <th class="knight_look">
        <img src="/images/oko_0.png">
      </th>
    </tr>
  </thead>

  <tbody>

    <?php foreach($wowGuildMembers as $wowGuildMember): $wowCharacter = $wowGuildMember->getWowCharacter(); ?>
      <?php include_component('wowGuild', 'memberRow', array('wow_character_id' => $wowGuildMember->getWowCharacterId())); ?>
    <?php endforeach; ?>

  </tbody>
</table>