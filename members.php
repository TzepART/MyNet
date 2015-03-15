<?php

include_once 'header.php';

if(!$loggedin) die();

echo "<div class='main'>";

if(isset($_GET['view']))
{
	$view = sanitizeString($mysqli,$_GET['view']);

	if($view == $user) $name = "Your";
	else $name = "$view's";

	echo "<h3>$name Profile</h3>";
	showProfile($mysqli,$view);


	echo "<a href='messages.php?view=$view' class='button'>View $name messages</a><br /><br />";
	die("</div></body></html>");
}

if (isset($_GET['add']))
{
	$add = sanitizeString($mysqli,$_GET['add']);

	$query = "SELECT * FROM friends WHERE user='$add' AND friend='$user'";

		if (!mysqli_num_rows(queryMysql($mysqli,$query)))
			queryMysql($mysqli,"INSERT INTO friends VALUES ('$add','$user')");
}

elseif (isset($_GET['remove'])) {
	$remove = sanitizeString($mysqli,$_GET['remove']);
	queryMysql($mysqli,"DELETE FROM friends WHERE user='$add' AND friend='$user'");

}

$result = queryMysql($mysqli,"SELECT user FROM members ORDER BY user");
$num = mysqli_num_rows($result);

echo "<h3>Other members</h3><ul>";

for ($i = 0; $i < $num; ++$i)
{
	$row = mysqli_fetch_row($result);
	if ($row[0] == $user) continue;

	echo "<li><a href='members.php?view=$row[0]'>$row[0]</a>";
	$follow = "follow";

	$t1 = mysqli_num_rows(queryMysql($mysqli,"SELECT * FROM friends WHERE user='$row[0]' AND friend='$user'"));
	$t2 = mysqli_num_rows(queryMysql($mysqli,"SELECT * FROM friends WHERE user='$user' AND friend='$row[0]'"));

	if(($t1+$t2)>1) echo "&harr; is a mutual friend";
	  //двунапрвленная стрелка - взаимный друг
	elseif ($t1) {
		echo "&larr; you are following";
		//Стрелка влево - вы заинтересованы в дружбе
	}
	elseif ($t2) {
		echo "&rarr; you are following";
		//Стрелка вправо - вами заинтересованы в дружбе
	}

	if(!$t1) 
		echo "[<a href='members.php?add=".$row[0]    ."'>$follow</a>]</li>";
	else
		echo "[<a href='members.php?remove=".$row[0] ."'>drop</a>]</li>"; //снять заинтересованность в дружбе

}

?>
</ul><br /></div></body></html>