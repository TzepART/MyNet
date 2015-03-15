<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


$dbhost = 'localhost';
$dbname = 'site_php';
$dbuser = 'root';
$dbpaswd = 'root';
$appname = 'MyNet';

$mysqli=mysqli_connect($dbhost, $dbuser, $dbpaswd, $dbname);
if (mysqli_connect_errno($mysqli)) {
	echo "Could not connect to MySQL".mysqli_connect_errno();
}


function createTable ($mysqli, $name, $query) {
	queryMysql($mysqli,"CREATE TABLE $name($query)");
	echo "Table '$name' create or it already exist<br />";
}

function queryMysql($mysqli,$query) 
{
	$result = $mysqli->query($query);
	
	if (!$result){
		printf("Errorcode: %d\n", $mysqli -> errno);
	}
	
	return $result;
}

//$q = "SELECT * FROM classic";
// $result = queryMysql($mysqli,$q);
// $res=mysqli_fetch_assoc($result);

function destroySession(){
	$_SESSION=array();
	if (session_id() != "" || isset($_COOKIE[session_name()]))
		setcookie(session_name(), '', time()-2592000, '/');
	session_destroy();
}

//удаляет потенциально вредный код
function sanitizeString($mysqli,$var){
	$var=strip_tags($var);
	$var=htmlentities($var);
	$var=stripcslashes($var);
	return $mysqli->real_escape_string($var);
}

function showProfile($mysqli,$user){
	if (file_exists("$user.jpeg"))
		echo "<img src='$user.jpeg' align='left' />";

	$result = $mysqli->query("SELECT * FROM profiles WHERE user='$user'");

	if (mysqli_num_rows($result)){
		$row = mysqli_fetch_assoc($result);
		echo stripcslashes($row['text']."<br clear=left /><br />");
		 
	}

}

// echo "<pre>";
// var_dump($res);

?>