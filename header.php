<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL);

include 'functions.php';

session_start();

echo "<!DOCTYPE html>\n<html><head><script src='OSC.js'></script>";


$userstr=' (Guest)';

if (isset($_SESSION['user']))
{
	$user=$_SESSION['user'];
	$loggedin=TRUE;
	$userstr = " ($user)";
}
else {
	//echo "Session not exists";
	$loggedin = FALSE;}

echo <<<_END
<title>$appname$userstr</title><link rel='stylesheet' href='styles.css' type='text/css' />
 </head><body><div class='appname'>$appname$userstr</div>
_END;

// echo "<pre>";
// var_dump($loggedin);

if($loggedin)
{	echo 
	<<<_END
	<br >
    <ul class="menu">
        <li><a href="members.php?view=$user">Home</a></li>
        <li><a href="members.php">Members</a></li>
        <li><a href="friends.php">Friends</a></li>
        <li><a href="messages.php">Messages</a></li>
        <li><a href="profile.php">Edit Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
	<br />
_END;
}
else
{
	echo 
	<<<_END
	<br />
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="signup.php">Sign up</a></li>
        <li><a href="login.php">Log in</a></li>
    </ul>
<br />
<span class="info">&#8658; You must be logged in to view this page.</span><br /><br />
_END;
}


?>