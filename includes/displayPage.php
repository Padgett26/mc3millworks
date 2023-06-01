<?php

$pStmt = $db->prepare("SELECT id,pageName FROM pages");
$pStmt->execute();
while ($pRow = $pStmt->fetch()) {
  $i = $pRow['id'];
  $j = str_ireplace(" ", "", $pRow['pageName']);
  if ($show == str_ireplace(" ", "", $j)) {
    $pageStmt = $db->prepare("SELECT * FROM pages WHERE id=?");
    $pageStmt->execute(array($i));
    $pageRow = $pageStmt->fetch();
    $pageId = $pageRow['id'];
    $pagePageName = $pageRow['pageName'];
    $shortName = str_ireplace(" ", "", $pagePageName);
    $firstLine = nl2br(make_links_clickable(html_entity_decode($pageRow['firstLine'], ENT_QUOTES)));
    $pageText = nl2br(make_links_clickable(html_entity_decode($pageRow['pageText'], ENT_QUOTES)));
    echo "<div class='pages' id='$shortName' style='display:block; $blockStyle'>\n";
    echo "<div style='text-align:center; margin:20px 0px;'><h1>$pagePageName</h1></div>\n";
    $picCheck = $db->prepare("SELECT picName,picExt,picDesc FROM pics WHERE pageId=? ORDER BY picOrder LIMIT 1");
    $picCheck->execute(array($pageId));
    $picR = $picCheck->fetch();
    $picName = ($picR['picName']) ? $picR['picName'] : "x";
    $picExt = ($picR['picExt']) ? $picR['picExt'] : "x";
    $picDesc = $picR['picDesc'];

    echo "<div style='min-height:150px;'>";
    if (file_exists("images/thumb/" . $picName . "." . $picExt)) {
      echo "<div style='float:left;'><img src='images/thumb/" . $picName . "." . $picExt . "' alt='' style='padding:2px; border:1px solid black; margin:0px 20px 10px 0px;' /></div>\n";
    }

    echo "<div style='text-align:justify; font-style:italic; font-size:1.25em; margin: 0px 40px 20px 40px;'>$firstLine</div>\n";
    echo "</div>\n";
    echo "<div style='text-align:justify; margin: 0px 50px 20px 30px;'>$pageText</div>\n";
    $picStmt2 = $db->prepare("SELECT COUNT(*) FROM pics WHERE pageId=?");
    $picStmt2->execute(array($pageId));
    $picRow2 = $picStmt2->fetch();
    $picCount = $picRow2[0];
    if ($picCount >= 1) {
      echo "<div><span style='font-size:.75em;'>Click on pictures to enlarge.</span></div>";
    }
    echo "<div class='flex-container' style='margin:10px 0px;'>";
    $picStmt = $db->prepare("SELECT picName,picExt,picDesc FROM pics WHERE pageId=? ORDER BY picOrder");
    $picStmt->execute(array($pageId));
    while ($picRow = $picStmt->fetch()) {
      $picName = $picRow['picName'];
      $picExt = $picRow['picExt'];
      $picDesc = $picRow['picDesc'];
      echo "<a href='images/" . $picName . "." . $picExt . "' data-lightbox='picSet$pageId' data-title='$picDesc'><img src='images/thumb/" . $picName . "." . $picExt . "' style='margin:2px; border:1px solid black; padding:2px;' alt=''/></a>\n";
    }
    echo "</div></div>\n";
  }
}