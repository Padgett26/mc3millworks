<?php
if (filter_input ( INPUT_POST, 'PageUp', FILTER_SANITIZE_NUMBER_INT )) {
	$pId = filter_input ( INPUT_POST, 'PageUp', FILTER_SANITIZE_NUMBER_INT );
	$a1 = htmlEntities ( trim ( $_POST ['pageText'] ), ENT_QUOTES );
	$pageText = filter_var ( $a1, FILTER_SANITIZE_STRING );
	$a2 = htmlEntities ( trim ( $_POST ['firstLine'] ), ENT_QUOTES );
	$fL = filter_var ( $a2, FILTER_SANITIZE_STRING );

	$pageUpdate = $db->prepare ( "UPDATE pages SET pageText = ?, firstLine = ? WHERE id = ?" );
	$pageUpdate->execute ( array (
			$pageText,
			$fL,
			$pId
	) );
}

if (filter_input ( INPUT_POST, 'picUp', FILTER_SANITIZE_STRING )) {
	$picUpId = filter_input ( INPUT_POST, 'picUp', FILTER_SANITIZE_STRING );
	$pId = filter_input ( INPUT_POST, 'pageIdUp', FILTER_SANITIZE_NUMBER_INT );
	$picOrder = filter_input ( INPUT_POST, 'picOrder', FILTER_SANITIZE_NUMBER_INT );
	$oldPicOrder = filter_input ( INPUT_POST, 'oldPicOrder', FILTER_SANITIZE_NUMBER_INT );
	$a = htmlEntities ( trim ( $_POST ['picDesc'] ), ENT_QUOTES );
	$picDesc = filter_var ( $a, FILTER_SANITIZE_STRING );
	$delPic = (filter_input ( INPUT_POST, 'delPic', FILTER_SANITIZE_NUMBER_INT ) == '1') ? '1' : '0';

	if ($delPic == '1') {
		$dPic1 = $db->prepare ( "SELECT picName, picExt, picOrder FROM pics WHERE id = ?" );
		$dPic1->execute ( array (
				$picUpId
		) );
		$dPic1Row = $dPic1->fetch ();
		$pName = $dPic1Row ['picName'];
		$pExt = $dPic1Row ['picExt'];
		$pOrder = $dPic1Row ['picOrder'];
		if (file_exists ( "images/" . $pName . "." . $pExt )) {
			unlink ( "images/" . $pName . "." . $pExt );
		}
		$dPic2 = $db->prepare ( "DELETE FROM pics WHERE id = ?" );
		$dPic2->execute ( array (
				$picUpId
		) );
		$dPic3 = $db->prepare ( "UPDATE pics SET picOrder = picOrder - 1 WHERE picOrder > ? && pageId = ?" );
		$dPic3->execute ( array (
				$picOrder,
				$pId
		) );
	} else {
		if ($picUpId == 'new') {
			$image = $_FILES ["image"] ["tmp_name"];
			$imageName = $time;
			list ( $width, $height ) = (getimagesize ( $image ) != null) ? getimagesize ( $image ) : null;
			if ($width != null && $height != null) {
				$imageType = getPicType ( $_FILES ["image"] ['type'] );
				processPic ( $imageName, '1000', '1000', $image, $imageType );
				processThumbPic ( $imageName, '150', '150', $image, $imageType );
				$pstmt = $db->prepare ( "INSERT INTO pics VALUES" . "(NULL,?,?,?,?,?,'0','0','0')" );
				$pstmt->execute ( array (
						$pId,
						$picOrder,
						$imageName,
						$imageType,
						$picDesc
				) );
			}
			$pstmt2 = $db->prepare ( "SELECT id FROM pics WHERE picName = ? && picDesc = ? ORDER BY id DESC LIMIT 1" );
			$pstmt2->execute ( array (
					$imageName,
					$picDesc
			) );
			$pstmt2r = $pstmt2->fetch ();
			$picUpId = $pstmt2r ['id'];
		}
		$uPic1 = $db->prepare ( "UPDATE pics SET picOrder = picOrder - 1 WHERE picOrder > ? && pageId = ?" );
		$uPic1->execute ( array (
				$oldPicOrder,
				$pId
		) );
		$uPic2 = $db->prepare ( "UPDATE pics SET picOrder = picOrder + 1 WHERE picOrder >= ? && pageId = ?" );
		$uPic2->execute ( array (
				$picOrder,
				$pId
		) );
		$uPic3 = $db->prepare ( "UPDATE pics SET picOrder = ? WHERE id = ?" );
		$uPic3->execute ( array (
				$picOrder,
				$picUpId
		) );
	}
}

$pStmt = $db->prepare ( "SELECT id,pageName FROM pages" );
$pStmt->execute ();
while ( $pRow = $pStmt->fetch () ) {
	$i = $pRow ['id'];
	$j = str_ireplace ( " ", "", $pRow ['pageName'] );
	if ($show == str_ireplace ( " ", "", $j )) {
		$pageStmt = $db->prepare ( "SELECT * FROM pages WHERE id=?" );
		$pageStmt->execute ( array (
				$i
		) );
		$pageRow = $pageStmt->fetch ();
		$pageId = $pageRow ['id'];
		$pagePageName = $pageRow ['pageName'];
		$shortName = str_ireplace ( " ", "", $pagePageName );
		$firstLine = $pageRow ['firstLine'];
		$pageText = $pageRow ['pageText'];
		echo "<div class='pages' id='$shortName' style='display:block; $blockStyle'>";
		echo "<div style='text-align:center; margin:20px 0px;'><h1>$pagePageName</h1></div>";

		echo "<form action='index.php?show=$shortName' method='post'>";
		echo "Highlighted first line:<br /><input type='text' name='firstLine' value='$firstLine' /><br /><br />\n";
		echo "<textarea name='pageText' cols='80' rows='10'>$pageText</textarea><br />\n";
		echo "<input type='hidden' name='PageUp' value='$pageId' />";
		echo "<input type='submit' value=' Update Page Text ' />";
		echo "</form>";

		echo "<div class='flex-container' style='margin:30px 0px;'>";
		echo "<table cellspacing='2' style='border:none;'><tr>";
		$t = 1;
		$picStmt2 = $db->prepare ( "SELECT COUNT(*) FROM pics WHERE pageId=?" );
		$picStmt2->execute ( array (
				$pageId
		) );
		$picRow2 = $picStmt2->fetch ();
		$picCount = $picRow2 [0];
		$picStmt = $db->prepare ( "SELECT id,picName,picExt,picDesc,picOrder FROM pics WHERE pageId=? ORDER BY picOrder" );
		$picStmt->execute ( array (
				$pageId
		) );
		while ( $picRow = $picStmt->fetch () ) {
			$picId = $picRow ['id'];
			$picName = $picRow ['picName'];
			$picExt = $picRow ['picExt'];
			$picDesc = $picRow ['picDesc'];
			$picOrder = $picRow ['picOrder'];
			echo "<td style='border:1px solid black; padding:5px 10px;'>";
			echo "<form action='index.php?show=$shortName' method='post'>";
			echo "<img src='images/" . $picName . "." . $picExt . "' style='max-width:200px; max-height:300px;' alt=''><br />";
			echo "Pic Order: <select name='picOrder' size='1'>\n";
			for($i = 1; $i <= $picCount; $i ++) {
				echo "<option value='$i'";
				echo ($i == $picOrder) ? " selected" : "";
				echo ">$i</option>\n";
			}
			echo "</select><br />\n";
			echo "Pic Description:<br />";
			echo "<textarea name='picDesc' cols='25' rows='5'>$picDesc</textarea><br />\n";
			echo "Delete this pic: <input type='checkbox' name='delPic' value='1' /><br />\n";
			echo "<input type='hidden' name='picUp' value='$picId' />\n";
			echo "<input type='hidden' name='pageIdUp' value='$pageId' />\n";
			echo "<input type='hidden' name='oldPicOrder' value='$picOrder' />\n";
			echo "<input type='submit' value=' Update Pic ' />\n";
			echo "</form>\n";
			echo "</td>\n";
			echo ($t % 3 == 0) ? "</tr><tr>" : "";
			$t ++;
		}
		$oldPicOrder = ($picCount + 1);
		echo "<td style='border:1px solid black; padding:5px 10px;'>";
		echo "<form action='index.php?show=$shortName' method='post' enctype='multipart/form-data'>";
		echo "Upload a new pic for this page:<br />";
		echo "<input type='file' name='image' /><br /><br />";
		echo "Pic Order: <select name='picOrder' size='1'>\n";
		for($i = 1; $i <= $oldPicOrder; $i ++) {
			echo "<option value='$i'";
			echo ($i == ($oldPicOrder)) ? " selected" : "";
			echo ">$i</option>\n";
		}
		echo "</select><br /><br />\n";
		echo "Pic Description:<br />";
		echo "<textarea name='picDesc' cols='25' rows='5'></textarea><br /><br />\n";
		echo "<input type='hidden' name='picUp' value='new' />\n";
		echo "<input type='hidden' name='pageIdUp' value='$pageId' />\n";
		echo "<input type='hidden' name='oldPicOrder' value='$oldPicOrder' />\n";
		echo "<input type='submit' value=' Update Pic ' />\n";
		echo "</form>\n";
		echo "</td>\n";
		echo "</tr></table>\n";
		echo "</div></div>\n";
	}
}