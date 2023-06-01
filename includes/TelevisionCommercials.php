<?php
$t = 1;
$tc = $db->prepare ( "SELECT * FROM commercials WHERE type = 'thco' ORDER BY RAND()" );
$tc->execute ();
while ( $row = $tc->fetch () ) {
	$youtubeCode = $row ['youtubeCode'];
	$description = nl2br ( make_links_clickable ( html_entity_decode ( $row ['Description'], ENT_QUOTES ) ) );
	echo "<div style='text-align:justify; margin:40px;'>\n";
	?>
		<video width="640" height="480"<?php
	echo ($t == 1) ? " autoplay" : "";
	?> controls poster="videos/<?php
	echo $youtubeCode;
	?>.png" preload="auto">
		<source src="videos/<?php
	echo $youtubeCode;
	?>.mp4" type="video/mp4">
		</video>
		<?php
	echo "$description</div>\n";
	$t ++;
}