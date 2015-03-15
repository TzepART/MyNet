<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


include_once 'header.php';
// $_POST['user']="";
// $_POST['pass'] = "";
// //echo "<pre>";
 // var_dump($_POST['user']);
 // var_dump($_POST['pass']);

echo <<<_END
<script>
function checkUser(user)
{
	if (user.value == '')
	{
		O('info').innerHTML = ''
		return
	}


params = "user="+user.value
request = new ajaxRequest()
request.open("POST","checkuser.php",true)
request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
request.setRequestHeader("Content-length",params.length)
request.setRequestHeader("Connection","close")

request.onreadystatechange=function()
	{
		if (this.readyState == 4)
			if (this.status == 200)
				if (this.responseText != null)
					O('info').innerHTML = this.responseText
	}
	request.send(params)

}

function ajaxRequest()
{
	try{var request = new XMLHttpRequest()}
	catch(e1){
		try{request = new ActiveXObject("Msxm12.XMLHTTP")}
		catch(e2){
			try{request = new ActiveXObject("Microsoft.XMLHTTP")}
			catch(e3){
					request=false
			}
		}

	}
	return request
}
</script>
<div class="main">
    <h3>Please enter your details to sign up</h3>
_END;

$error = $user = $pass = "";
if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user']))
{
	$user = sanitizeString($mysqli,$_POST['user']);
	$pass = sanitizeString($mysqli,$_POST['pass']);
	// var_dump($user);
	// var_dump($pass);

	if($user == "" || $pass == "")
	{
		$error = "You have not entered data<br /><br />";
	}
	else
	{	
		if (mysqli_num_rows(queryMysql($mysqli,"SELECT * FROM members WHERE user='$user'")))
			{	
				$error = "Sorry, This name already exist.<br /><br />";
				}
			else{
				queryMysql($mysqli,"INSERT INTO members VALUES('id','$user','$pass')");
				echo "<h4>Account created</h4>Please Log in.<br /><br />";
			}
	}
}

echo <<<_END
<form action="signup.php" method="post">
    $error
    <span class="fieldname">Username</span>
    <input type="text" maxlength="16" name='user' value='$user' onBlur="checkUser(this)" /><span id="info"></span><br />
    <span class="fieldname">Password</span>
    <input type="text" maxlength="16" name='pass' value='$pass' /><br />
_END;

?>

<span class="fieldname">&nbsp;</span>
<input type="submit" value="Sign up" />
</form></div><br />
</body>
</html>