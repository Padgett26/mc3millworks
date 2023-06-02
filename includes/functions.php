<?php
session_start();

include "../globalFunctions.php";

$db = db_mc3();

$buildMode = false;
$time = time();
$domain = "mc3millworks.com";

function cropImage ($imagePath, $startX, $startY, $width, $height)
{
    $imagick = new \Imagick(realpath($imagePath));
    $imagick->cropImage($width, $height, $startX, $startY);
    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();
}
