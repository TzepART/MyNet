<?php

include_once 'header.php';

if(!$loggedin) die();

echo "<div class='main'><h3>Your Profile</h3>";


if (isset($_POST['text']))
{
	$text = sanitizeString($mysqli,$_POST['text']);
	$text = preg_replace('/\s\s+/', ' ', $text);

	$a = mysqli_num_rows(queryMysql($mysqli,"SELECT * FROM profiles WHERE user='$user'"));
		
	if($a)
		queryMysql($mysqli,"UPDATE profiles SET text = '$text' WHERE user='$user'");
		
	else queryMysql($mysqli,"INSERT INTO profiles VALUES('$user','$text')");

}
else
{
	$result = $mysqli->query("SELECT * FROM profiles WHERE user='$user'");

	if (mysqli_num_rows($result))
	{
		$row=mysqli_fetch_row($result);
		$text = stripcslashes($row[1]);
	}
	else $text = "";
}



$text = stripcslashes(preg_replace('/\s\s+/', ' ', $text));
if (isset($_FILES['image']['name']))
{

	$saveto = "$user.jpeg";
	move_uploaded_file(($_FILES['image']['tmp_name']), $saveto);
	$typeok = TRUE;



	switch ($_FILES['image']['type']) {
		case "image/gif":
		$src = imagecreatefromgif($saveto);
			break;
	
		case "image/pjpeg":
			
		case "image/jpeg":
		$src = imagecreatefromjpeg($saveto);
			break;

		case "image/png":
		$src = imagecreatefrompng($saveto);
			break;

		
		default:
			$typeok = FALSE;
			break;
	}

	
	
	if($typeok)
	{
		list($w, $h) = getimagesize($saveto);
		$max = 200;
		$tw = $w;
		$th = $h;
		
		if($w > $h && $max < $w)
		{
			$th = $max/$w * $h;
			$tw = $max;
		}

		elseif($h > $w && $max < $h)
			{
				$tw = $max/$h * $w;
				$th = $max;
			}
		elseif ($max < $w) 
		{
			$tw = $th = $max;
		}
		

$tmp = imagecreatetruecolor($tw, $th);
imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
imageconvolution($tmp, array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1)), 8, 0);
imagejpeg($tmp,$saveto);
imagedestroy($tmp);
imagedestroy($src);

	}
}

showProfile($mysqli,$user);

echo <<<_END
<form action="profile.php" method="post" enctype="multipart/form-data">
    <h3>Enter or edit your details and/or upload an image</h3>
    <textarea name="text" cols="50" rows="3">$text</textarea><br />
_END;
?>


Image: <input type='file' name='image' size='14' maxlength='32' />
<input type='submit' value='Save Profile' />
</form></div><br /></body></html>
