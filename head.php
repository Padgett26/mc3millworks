<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />
<title>MC3 Millworks</title>
<link rel="shortcut icon" href="images/favicon.ico" />
<meta name="description" content="MC3 Millworks offers complete design, manufacturing, and installation of all custom cabinets, millwork, furniture, and laminate countertops." />
<meta name="keywords" content="Colby, Kansas, St Francis, Cabinetry, MC3 Millworks, Thomas County Cabinetry, cabinetry, complete design, manufacturing, custom cabinets, millwork, furniture, laminate countertops" />
<link rel="stylesheet" href="css/lightbox.css">
<link href="https://fonts.googleapis.com/css?family=Arizonia" rel="stylesheet">
<style type="text/css">
  .homeMenuBuildMode {
    float:left;
    padding:10px 20px;
    color:#000000;
    font-size:1.25em;
    text-decoration:none;
    font-family: 'Tahoma', sans-serif;
  }
  .homeMenu {
    float:left;
    padding:10px 20px;
    color:#000000;
    font-size:1.0em;
    text-decoration:none;
    font-family: 'Tahoma', sans-serif;
  }
  .homeMenu:hover {
    background-color: #ffffff;
  }
  .flex-container {
    display: flex;
    flex-wrap: wrap;
    align-content: space-between;
  }
  .clearfix::after {
    content: "";
    clear: both;
    display: table;
  }
</style>
<script type="text/javascript">
  var height = window.innerHeight
          || document.documentElement.clientHeight
          || document.body.clientHeight;
  var w = window.innerWidth
          || document.documentElement.clientWidth
          || document.body.clientWidth;
  var width = (w - 10);

  function sizeBoxes() {
<?php if ($show == "Home") { ?>
      var r = document.getElementById("homePicBox");
      if (width > 1000) {
        r.style.height = 1000 * <?php echo $homePicHeight / $homePicWidth; ?> + "px";
        r.style.width = "1000px";
      } else {
        r.style.height = width * <?php echo $homePicHeight / $homePicWidth; ?> + "px";
        r.style.width = width + "px";
      }

      var s = document.getElementById("homeBox");
      if (width <= 700) {
        s.style.bottom = "0px";
      } else {
        s.style.top = "400px";
      }
<?php } else { ?>
      var v = document.getElementById("homePicBox");
      if (width > 1000) {
        v.style.width = "1000px";
      } else {
        v.style.width = width + "px";
      }

      var q = document.getElementById("pageBanner");
      if (width > 1000) {
        q.style.width = "1000px";
        q.style.height = "250px";
      } else {
        q.style.width = width + "px";
        q.style.height = (width / 4) + "px";
      }

      var w = document.getElementById("pageArticle");
      if (width > 1000) {
        w.style.width = "775px";
        w.style.position = "relative";
        w.style.top = "0px";
        w.style.left = "0px";
      } else {
        w.style.width = width - 30 + "px";
        w.style.position = "relative";
        w.style.top = "0px";
        w.style.left = "2px";
      }

      var y = document.getElementById("pageMenu");
      y.style.display = (width <= 1000) ? "none" : "inline-block";
      y.style.width = (width <= 1000) ? (width - 52) + "px" : "200px";

      var z = document.getElementById("menuButton");
      z.style.display = (width <= 1000) ? "inline-block" : "none";

      var a = document.getElementById("commercialSize");
      if (width <= 1000) {
        a.style.width = (width - 110) + "px";
        a.style.height = ((width - 110) * .75) + "px";
      }
<?php } ?>

    var t = document.getElementById("homeLogo");
    if (width <= 700) {
      t.style.maxWidth = "75%";
    }

    var u = document.getElementById("homeText");
    if (width <= 700) {
      u.style.fontSize = "1.0em";
    }

    var x = document.getElementsByClassName("homeMenu");
    if (width <= 700) {
      for (i = 0; i < x.length; i++) {
        x[i].style.fontSize = "0.75em";
      }
    }
  }

  function displayPage(p) {
    var x = document.getElementsByClassName("pages");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }

    var y = document.getElementById(p);
    y.style.display = "block";
  }

  function toggleMenu() {
    $("#pageMenu").fadeToggle(1000);
    $("#pageArticle").fadeToggle(1000);
  }

  function getPage(page) {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function ()
    {
      if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
      {
        document.getElementById("showPage").innerHTML = xmlhttp.responseText;
      }
    };
    xmlhttp.open("GET", "pageAjax.php?getPage=" + page, true);
    xmlhttp.send();

    if (width <= 1000) {
      toggleMenu();
    }
  }
</script>