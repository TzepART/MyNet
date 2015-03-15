<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL);

include 'functions.php';

if(isset($_POST['user']))
{
	$user =sanitizeString($mysqli,$_POST['user']);

	if(mysqli_num_rows(queryMysql($mysqli,"SELECT * FROM members WHERE user='$user'")))
		echo "<span class='taken'>&nbsp;&#x2718;Sorry, this name is taken</span>";
	else
		echo "<span class='available'>&nbsp;&#x2714;This name is available</span>";
}

?>