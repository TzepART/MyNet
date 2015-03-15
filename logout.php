<?php

include_once 'header.php';

if(isset($_SESSION['user']))
{
	destroySession();
	echo <<<_END
	<div class="main">
    <a href="index.php">click here</a> to refresh the screen.
</div><br /><br />   
_END;
}
else echo "<div class='main'><br />You cannot log out because you are not logged in.</div>";

?>
<br /><br /> 
</body>
</html>