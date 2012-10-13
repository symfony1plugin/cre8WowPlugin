<?php

function renderWowItem(WowItem $wowItem = null, $emptyValue = "&nbsp;") {
  return $wowItem ?
    '<a href="http://www.wowhead.com/?item=' . $wowItem->getId() . '" class="q' . $wowItem->getQuality() . '" >' . image_tag('/images/armory/51x51/' . $wowItem->getIcon(), array('style' => 'border: none;')) . '</a>'
    : $emptyValue;
}

function renderWowCharacterItem(WowCharacterItem $wowCharacterItem = null, $emptyValue = "&nbsp;") {
  return $wowCharacterItem ? renderWowItem($wowCharacterItem->getWowItem(), $emptyValue) : $emptyValue;
}

function linkToWowHeadItem(WowItem $wowItem, $type = 'img', $imageSize = '64x64') {
  $linkVal = image_tag('/images/armory/' . $imageSize . '/' . $wowItem->getIcon(), array('style' => 'border: none;'));
  if($type == 'txt') {
    $linkVal = $wowItem->getName();
  }
  return link_to($linkVal, 'http://www.wowhead.com/?item=' . $wowItem->getId(), array('class' => 'q' . $wowItem->getQuality()));
}


?>
