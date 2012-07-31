<?php
require 'db.php';
#connectRoam();

echo <<<HTML
<html>
<head>
<title>Create User</title>
<style type="text/css">
	table { border:1px solid #000;}
</style>
</head>

<body>
<h4>Pick a name</h4>
<form action="processEnter.php" method="post">
<table cellpadding="8" bgcolor="lightgrey" width="30%">
	<tr><td>Name:</td>
		<td><input name="name" type="text" /></td></tr>
	<tr><td>Description:</td>
		<td><input name="description" type="text" /></td></tr>
</table>
<input name="action" type="hidden" value="register" />
<br><input type="submit" value="Add User"/>
</form>
<a href="enter.php">Back to sign-in</a>
</body>
</html>
HTML;
?>