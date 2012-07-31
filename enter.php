<?php
require 'db.php';
#connectRoam();

if( isset( $_GET['retry'] ) ) {
	$retry_msg = <<<RETRY
<span style="color: red;font-size : 14pt">
"I don't know that person. Try another or register.
</span>
<p>
RETRY;
} else {
	$retry_msg = "";
}

echo <<<HTML
<html>
<head>
<title>Welcome to Roam</title>
<style type="text/css">
	table { border:1px solid #000;}
</style>
</head>

<body>
$retry_msg
<h4>Who are you?</h4>
<form action="processEnter.php" method="post">
<table cellpadding="8" bgcolor="lightgrey" width="30%">
	<tr><td>Name:</td>
		<td><input name="name" type="text" /></td></tr>
</table>
<input name="action" type="hidden" value="enter" />
<br><input type="submit" value="That's Me"/>
</form>
<a href="register.php">Need to add a user?</a>
</body>
</html>
HTML;
?>