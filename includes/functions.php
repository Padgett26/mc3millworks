<?php
session_start ();

$dbhost = 'localhost';
$dbname = 'mc3';
$dbuser = 'mc3_user';
$dbpass = 'PloiK098m';

try {
	$db = new PDO ( "mysql:host=$dbhost; dbname=$dbname", "$dbuser", "$dbpass" );
} catch ( PDOException $e ) {
	echo "";
}

$buildMode = false;
$time = time ();
function cropImage($imagePath, $startX, $startY, $width, $height) {
	$imagick = new \Imagick ( realpath ( $imagePath ) );
	$imagick->cropImage ( $width, $height, $startX, $startY );
	header ( "Content-Type: image/jpg" );
	echo $imagick->getImageBlob ();
}

// *** Log out ***
function destroySession() {
	$_SESSION = array ();

	if (ini_get ( "session.use_cookies" )) {
		$params = session_get_cookie_params ();
		setcookie ( session_name (), '', time () - 42000, $params ["path"], $params ["domain"], $params ["secure"], $params ["httponly"] );
	}

	session_destroy ();
}
function make_links_clickable($text) {
	return preg_replace ( '!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', "<a href='$1' target='_blank' style='color:#734021; text-decoration:underline;'>$1</a>", $text );
}
function getPicType($imageType) {
	switch ($imageType) {
		case "image/gif" :
			$picExt = "gif";
			break;
		case "image/jpeg" :
			$picExt = "jpg";
			break;
		case "image/pjpeg" :
			$picExt = "jpg";
			break;
		case "image/png" :
			$picExt = "png";
			break;
		default :
			$picExt = "xxx";
			break;
	}
	return $picExt;
}
function processPic($imageName, $imageWidth, $imageHeight, $tmpFile, $picExt) {
	$folder = "images";
	if (! is_dir ( "$folder" )) {
		mkdir ( "$folder", 0777, true );
	}

	$saveto = "$folder/$imageName.$picExt";

	list ( $width, $height ) = (getimagesize ( $tmpFile ) != null) ? getimagesize ( $tmpFile ) : null;
	if ($width != null && $height != null) {
		$image = new Imagick ( $tmpFile );
		$image->thumbnailImage ( $imageWidth, $imageHeight, true );
		$image->writeImage ( $saveto );
	}
}
function processThumbPic($imageName, $imageWidth, $imageHeight, $tmpFile, $picExt) {
	$folder = "images/thumb";
	if (! is_dir ( "$folder" )) {
		mkdir ( "$folder", 0755, true );
	}

	$saveto = "$folder/$imageName.$picExt";

	list ( $width, $height ) = (getimagesize ( $tmpFile ) != null) ? getimagesize ( $tmpFile ) : null;
	if ($width != null && $height != null) {
		$image = new Imagick ( $tmpFile );
		$image->thumbnailImage ( $imageWidth, $imageHeight, true );
		$image->writeImage ( $saveto );
	}
}
function money($amt) {
	settype ( $amt, "float" );
	$fmt = new NumberFormatter ( 'en_US', NumberFormatter::CURRENCY );
	return $fmt->formatCurrency ( $amt, "USD" );
}