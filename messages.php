<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


include_once 'header.php';

if(!$loggedin) die();


if(isset($_GET['view']))	$view = sanitizeString($mysqli,$_GET['view']);

else                        $view = "$user";

if(isset($_POST['text']))
{
	$text = sanitizeString($mysqli,$_POST['text']);

	if ($text != "") {
		$pm = substr(sanitizeString($mysqli,$_POST['pm']), 0, 1);
		$time = time();
		queryMysql($mysqli,"INSERT INTO messages VALUES (NULL, '$user', '$view', '$pm', '$time', '$text')");

	}
}

if($view != "")
{
	if ($view == $user) $name1 = $name2 = "Your";
	else
	{
		$name1 = "<a href='members.php?view=$view'>$view</a>'s";
		$name2 = "$view's";
	}

	echo "<div class='name'><h3>$name1 Messages</h3></div>";

	showProfile($mysqli,$view);
	echo <<<_END
<form action="messages.php?view=$view" method="post">
    Type here to leave a messages: <br />
    <textarea name="text" cols="40" rows="3"></textarea><br />
    Public <input type="radio" name="pm" value="0" checked="checked" />
    Private <input type="radio" name="pm" value="1" />
    <input type="submit" value="Post Messages" / >
</form><br />
_END;

if(isset($_GET['erase']))
{
	$erase = sanitizeString($mysqli,$_GET['erase']);
	queryMysql($mysqli,"DELETE FROM messages WHERE id='$erase' AND recip='$user'");
}


$query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
$result = queryMysql($mysqli,$query);
$num = mysqli_num_rows($result);

for ($i = 0; $i < $num; ++$i)
{
	$row = mysqli_fetch_row($result);
	
		if($row[3] == 0 || $row[1] == $user || $row[2] == $user)
		{
			echo date('M jS \'y g:ya:', $row[4]);
			echo "<a href='messages.php?view=$row[1]'>$row[1]</a>";

			if ($row[3] == 0)
				echo "wrote: &quot;$row[5]&quot; ";
			else
				echo "whispered: <span class='whisper'>&quot;$row[5]&quot;</span>";

			if ($row[2] == $user)
				echo "[<a href='messages.php?view=$view&erase=$row[0]'></a>]";
						//стереть
			echo "<br />";

		}
	}
	

}

if(!$num) echo "<br /><span class='info'>No messages yet</span><br /><br />";

echo "<br /><a class='button' href='messages.php?view=$view'>Refresh messages</a><a class='button' href='friends.php?view=$view'>View $name2 friends</a>";

?>
</div>
<br />
</body>
</html>