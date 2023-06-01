<?php

$show = (filter_input(INPUT_GET, 'show', FILTER_SANITIZE_STRING)) ? filter_input(INPUT_GET, 'show', FILTER_SANITIZE_STRING) : "Home";

if (filter_input(INPUT_GET, 'logout', FILTER_SANITIZE_STRING) == 'yep') {
  destroySession();
}

$loginErr = "";

if (filter_input(INPUT_POST, 'login', FILTER_SANITIZE_NUMBER_INT) == "1") {
  $userName = (filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING)) ? trim(filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING)) : '0';
  $login1stmt = $db->prepare("SELECT id, salt FROM users WHERE userName = ?");
  $login1stmt->execute(array($userName));
  $login1row = $login1stmt->fetch();
  $salt = $login1row['salt'];
  $checkId = (isset($login1row['id']) && $login1row['id'] > 0) ? $login1row['id'] : '0';
  $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);
  $hidepwd = hash('sha512', ($salt . $pwd), FALSE);
  $login2stmt = $db->prepare("SELECT id FROM users WHERE userName = ? && password = ?");
  $login2stmt->execute(array($userName, $hidepwd));
  $login2row = $login2stmt->fetch();
  if ($login2row['id']) {
    $_SESSION['loggedIn'] = '1';
    $loginErr = "You are now logged in.";
  } else {
    $_SESSION['loggedIn'] = '0';
    $loginErr = "Your email / password combination isn't correct.";
  }
}

if (isset($_SESSION['loggedIn'])) {
  $loggedIn = ($_SESSION['loggedIn'] == '1') ? '1' : '0';
} else {
  $_SESSION['loggedIn'] = '0';
  $loggedIn = '0';
}

if (filter_input(INPUT_POST, 'updateUser', FILTER_SANITIZE_NUMBER_INT)) {
  $ui = filter_input(INPUT_POST, 'updateUser', FILTER_SANITIZE_NUMBER_INT);
  $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);
  $delUser = (filter_input(INPUT_POST, 'delUser', FILTER_SANITIZE_NUMBER_INT) == "1") ? "1" : "0";

  if ($delUser == "1") {
    $d1 = $db->prepare("DELETE FROM users WHERE id = ?");
    $d1->execute(array($ui));
    $loginErr = "The user has been deleted.";
  } else {
    $s1 = $db->prepare("SELECT salt FROM users WHERE id = ?");
    $s1->execute(array($ui));
    $s1Row = $s1->fetch();
    $salt = $s1Row['salt'];
    $hidepwd = hash('sha512', ($salt . $pwd), FALSE);

    $s2 = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $s2->execute(array($hidepwd, $ui));
    $loginErr = "The password has been updated.";
  }
}

if (filter_input(INPUT_POST, 'newUser', FILTER_SANITIZE_NUMBER_INT) == "1") {
  $un = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
  $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);
  $newSalt = rand(100000, 999999);
  $hidepwd = hash('sha512', ($newSalt . $pwd), FALSE);
  $i1 = $db->prepare("INSERT INTO users VALUES" . "(NULL,?,?,?,'0','0','0')");
  $i1->execute(array($un, $hidepwd, $newSalt));
  $loginErr = "The new user log in has been set.";
}

if (filter_input(INPUT_POST, 'changePage', FILTER_SANITIZE_STRING)) {
  $c = filter_input(INPUT_POST, 'changePage', FILTER_SANITIZE_STRING);
  $pageName = filter_input(INPUT_POST, 'pageName', FILTER_SANITIZE_STRING);
  $childOf = filter_input(INPUT_POST, 'childOf', FILTER_SANITIZE_NUMBER_INT);
  $delPage = (filter_input(INPUT_POST, 'delPage', FILTER_SANITIZE_NUMBER_INT) == "1") ? "1" : "0";

  if ($delPage == "1") {
    $p1 = $db->prepare("DELETE FROM pages WHERE id = ?");
    $p1->execute(array($c));
    $delPics1 = $db->prepare("SELECT id, picName, picExt FROM pics WHERE pageId = ?");
    $delPics1->execute(array($c));
    while ($delPics1r = $delPics1->fetch()) {
      $i = $delPics1r['id'];
      $n = $delPics1r['picName'];
      $e = $delPics1r['picExt'];
      if (file_exists("images/$n.$e")) {
        unlink("images/$n.$e");
      }
      $pd1 = $db->prepare("DELETE FROM pics WHERE id = ?");
      $pd1->execute(array($i));
    }

    $subp1 = $db->prepare("SELECT id FROM pages WHERE childOf = ?");
    $subp1->execute(array($c));
    while ($subp1r = $subp1->fetch()) {
      $dId = $subp1r['id'];
      $q1 = $db->prepare("DELETE FROM pages WHERE id = ?");
      $q1->execute(array($dId));
      $delq1 = $db->prepare("SELECT id, picName, picExt FROM pics WHERE pageId = ?");
      $delq1->execute(array($dId));
      while ($delq1r = $delq1->fetch()) {
        $i = $delq1r['id'];
        $n = $delq1r['picName'];
        $e = $delq1r['picExt'];
        if (file_exists("images/$n.$e")) {
          unlink("images/$n.$e");
        }
        $qd1 = $db->prepare("DELETE FROM pics WHERE id = ?");
        $qd1->execute(array($i));
      }
    }
  } else {
    if ($c == "new") {
      $p2 = $db->prepare("INSERT INTO pages VALUES" . "(NULL,?,?,?,?,'0','0','0')");
      $p2->execute(array($childOf, $pageName, "", ""));
      $show = str_ireplace(" ", "", $pageName);
    } else {
      $p2 = $db->prepare("UPDATE pages SET pageName = ? WHERE id = ?");
      $p2->execute(array($pageName, $c));
    }
  }
}