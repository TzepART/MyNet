<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


include_once 'header.php';


echo "<br /><span class='main'>Welcome to MyNET!";

if($loggedin) echo "$user, you are logged in.";
	else
		echo " Please sign up or/and log in! :-)";


?>

</span><br /></body></html>