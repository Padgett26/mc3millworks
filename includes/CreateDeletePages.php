Create / Delete Pages
<table cellspacing="0px">
  <tr>
    <td style='text-align:left; padding:5px 10px;'>
      <form action='index.php?show=CreateDeletePages' method='post'>
        New <input type='text' name='pageName' value='' /></td>
    <td style=''>
      Sub-page of: <select name="childOf" size="1">
        <option value="0" selected="selected">none</option>
        <?php
        $navStmt2 = $db->prepare("SELECT id,pageName FROM pages WHERE childOf=? ORDER BY pageName");
        $navStmt2->execute(array('0'));
        while ($navRow2 = $navStmt2->fetch()) {
          $navId2 = $navRow2['id'];
          $navPageName2 = $navRow2['pageName'];
          echo "<option value='$navId2'>$navPageName2</option>\n";
        }
        ?>
      </select></td>
    <td style=''>
      <input type='hidden' name='changePage' value='new' />
      <input type='submit' value=' Create ' />
      </form>
    </td>
  </tr>

  <?php
  $navStmt = $db->prepare("SELECT id,pageName FROM pages WHERE childOf=? ORDER BY pageName");
  $navStmt->execute(array('0'));
  while ($navRow = $navStmt->fetch()) {
    $navId = $navRow['id'];
    $navPageName = $navRow['pageName'];
    echo "<tr><td style='text-align:left; padding:5px 10px;'>";
    echo "<form action='index.php?show=CreateDeletePages' method='post'>";
    echo "<input type='text' name='pageName' value='$navPageName' /></td>\n";
    echo "<td style=''>Delete page and all sub-pages under it? <input type='checkbox' name='delPage' value='1' /></td>\n";
    echo "<td style=''><input type='hidden' name='changePage' value='$navId' /><input type='hidden' name='childOf' value='0' /><input type='submit' value=' Change ' /></form></td></tr>\n";
    $childStmt = $db->prepare("SELECT id,pageName FROM pages WHERE childOf=? ORDER BY pageName");
    $childStmt->execute(array($navId));
    while ($childRow = $childStmt->fetch()) {
      $childId = $childRow['id'];
      $childPageName = $childRow['pageName'];
      echo "<tr><td style='text-align:left; padding:5px 10px;'>";
      echo "<form action='index.php?show=CreateDeletePages' method='post'>";
      echo "\t- <input type='text' name='pageName' value='$childPageName' /></td>\n";
      echo "<td style=''>Delete page? <input type='checkbox' name='delPage' value='1' /></td>\n";
      echo "<td style=''><input type='hidden' name='changePage' value='$childId' /><input type='hidden' name='childOf' value='$navId' /><input type='submit' value=' Change ' /></form></td></tr>\n";
    }
  }
  ?>
</table>