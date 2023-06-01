<nav id="pageMenu" style="float:left; display:inline-block; height:100%; padding:10px; background-color:#ffffff; color:#000000; position:relative; top: 0px; left:0px; border:1px solid black; vertical-align:top;">
    <?php
    $navStmt = $db->prepare("SELECT id,pageName FROM pages WHERE childOf=? ORDER BY displayOrder");
    $navStmt->execute(array('0'));
    while ($navRow = $navStmt->fetch()) {
      $navId = $navRow['id'];
      $navPageName = $navRow['pageName'];
      $shortName = str_ireplace(" ", "", $navPageName);
      $npn = str_ireplace("New", "<span style='color:red;'>New</span>", $navPageName);
      echo "<div id='nav$navId' style='width:100%; text-align:left; padding:5px 10px; cursor:pointer; text-decoration:none; color:black;' onclick='getPage(\"$shortName\")'>$npn</div><div style='width:75%; height:1px; background-color:#dddddd; margin:0px auto;'></div>\n";
      $childStmt = $db->prepare("SELECT id,pageName FROM pages WHERE childOf=? ORDER BY pageName");
      $childStmt->execute(array($navId));
      while ($childRow = $childStmt->fetch()) {
        $childId = $childRow['id'];
        $childPageName = $childRow['pageName'];
        $cShortName = str_ireplace(" ", "", $childPageName);
        echo "<div id='nav$childId' style='width:100%; text-align:left; padding:5px 15px; cursor:pointer; text-decoration:none; color:black;' onclick='getPage(\"$cShortName\")'>- $childPageName</div><div style='width:75%; height:1px; background-color:#dddddd; margin:0px auto;'></div>\n";
      }
    }
    echo "<div style='width:100%; text-align:left; padding:5px 10px; cursor:pointer; text-decoration:none; color:black;' onclick='getPage(\"TelevisionCommercials\")'>Television Commercials</div><div style='width:75%; height:1px; background-color:#dddddd; margin:0px auto;'></div>\n";
    echo ($loggedIn == 0) ? "<div id='navLogIn' style='width:100%; text-align:left; padding:5px 10px; cursor:pointer; text-decoration:none; color:black;' onclick='getPage(\"LogIn\")'>Log In</div>" : "<div id='navLogOut' style='width:100%; text-align:left; padding:5px 10px;'><a href='index.php?show=LogIn&logout=yep' style='text-decoration:none; color:black;'>Log Out</a></div>";
    echo "<div style='width:75%; height:1px; background-color:#dddddd; margin:0px auto;'></div>\n";
    if ($loggedIn == 1) {
      echo "<div id='navCreateDeletePages' style='width:100%; text-align:left; padding:5px 10px; cursor:pointer; text-decoration:none; color:black;' onclick='getPage(\"CreateDeletePages\")'>Create/Delete Pages</div>\n";
    }
  ?>
  </nav>
  <div id="menuButton" style="float:left; display:none; height:100%; padding:45% 5px; margin:0px 2px; text-align:center; background-color:#ffffff; cursor:pointer; border:1px solid black; margin:0px; color:#000000; position:relative; top: 0px; left:0px; vertical-align:top;" onclick="toggleMenu()">
    M<br />E<br />N<br />U
  </div>