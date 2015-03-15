<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL);


include 'header.php';

echo "<div class='main'>
		<h3>Please, enter your Login and Password</h3>";

$error = $user = $pass = "";

if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user']))
{
	$user =sanitizeString($mysqli,$_POST['user']);
	$pass =sanitizeString($mysqli,$_POST['pass']);

	if($user == "" || $pass == ""){
		echo "You have not entered data<br /><br />";
	}
	else
	{
		$query="SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'";

		if (mysqli_num_rows(queryMysql($mysqli,$query)) == 0)
			$error = "<span class='error'>Username or Password invalid<br /><br />";
			else{
				$_SESSION['user']=$user;
				$_SESSION['pass']=$pass;
				echo "You are logged in. Plaease <a href='members.php?view=$user'>clik here</a>to contine.<br /><br />";
			}
	}
}

echo <<<_END
<form action="login.php" method="post">
    $error
    <span class="fieldname">Username</span>
    <input type="text" maxlength="16" name="user" value="$user" onBlur="checkUser(this)" /><span id="info"></span><br />
    <span class="fieldname">Password</span>
    <input type="text" maxlength="16" name="pass" value="$pass" /><br />
_END;

?>


<br />
<span class="fieldname">&nbsp;</span>
<input type="submit" value="Login" />
</form></div><br />
</body>
</html>