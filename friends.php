<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL);


include_once 'header.php';

if(!$loggedin) die();


if(isset($_GET['view']))	$view = sanitizeString($mysqli,$_GET['view']);

else                    $view = "$user";

if($view == $user)
{
	$name1 = "<a href='members.php?view=$view'>$view</a>'s";
	$name2 = "$view's";
	$name3 = "$view is";
}

echo "<div class='main'>";

//если надо вывести профиль пользователя, то раскомментируй
showProfile($mysqli,$view);

$followers = array();
$following = array();

$result = queryMysql($mysqli,"SELECT * FROM friends WHERE user='$view'");
$num = mysqli_num_rows($result);

for ($i=0; $i < $num; ++$i)
{
	$row = mysqli_fetch_row($result);
	$followers[$i] = $row[1];
}

$result = queryMysql($mysqli,"SELECT * FROM friends WHERE user='$view'");
$num = mysqli_num_rows($result);

for ($i=0; $i < $num; ++$i)
{
	$row = mysqli_fetch_row($result);
	$following[$i] = $row[1];
}

$muttual = array_intersect($followers, $following); //в массиве followers находятся все люди, которые проявляют нтерес к дружбе, в массиве following к которым проявляется интерес. $muttual = array_intersect($followers, $following) - для определения взаимного интереса к дружбе. array_intersect - функция выделяющая элементы общие для двух массивов. Затем применяется функция array_diff() для определения тех людей, которые не являются общими друзьями
$followers = array_diff($followers, $muttual);
$following = array_diff($following, $muttual);
$friends = FALSE;

if(sizeof($muttual))
{
	echo "<span class='subhead'>$name2 mutual friends</span><ul>";
	foreach ($muttual as $friend) 
		echo "<li><a href='members.php?view=$friend'>$friend</a></li>";
	echo "</ul>";
	$friends = TRUE;
	
}

if(sizeof($followers))
{
	echo "<span class='subhead'>$name2 followers</span><ul>";
	foreach ($followers as $friend) 
		echo "<li><a href='members.php?view=$friend'>$friend</a></li>";
	echo "</ul>";
	$friends = TRUE;
	
}

if(sizeof($following))
{
	echo "<span class='subhead'>$name3 following</span><ul>";
	foreach ($ffollowing as $friend) 
		echo "<li><a href='members.php?view=$friend'>$friend</a></li>";
	echo "</ul>";
	$friends = TRUE;
	
}

if (!$friends) 
	echo "<br />You don't have any friends yet.<br /><br />";

echo "<a href='messages.php?view=$view' class='button'>View $name2 messages</a>";


?>

</div><br /></body></html>