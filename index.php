<?php
include "includes/functions.php";
include "includes/config.php";
list ( $homePicWidth, $homePicHeight ) = (getimagesize ( "images/homePic.jpg" ) != null) ? getimagesize ( "images/homePic.jpg" ) : null;
?>
<!DOCTYPE html>
<html>
  <head>
    <?php

include "head.php";
				?>
  </head>
  <body style="background-image: url('images/bg.gif'); width:100%; margin:0px; padding:0px; position: relative; top: 0px; left:0px;" onload="sizeBoxes()">
    <div id="homePicBox" style="margin: auto; position: relative; top: 10px; left:0px; border:0px solid white;">
      <?php
						$get = ($show == "Home") ? "Home" : "page";
						include $get . ".php";
						?>
    </div>
  </body>
</html>