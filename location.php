<?php
require 'db.php';
connectRoam();

if( ! isset( $_GET['user'] ) ) {
	die ( "location.php called without 'user' param on query line" );
}

$personId = $_GET['user'];
$currentloc = getLocationByPerson( $personId )['location_id'];
$locinfo = getLocationById( $currentloc );

echo <<<HEADER
<html>
<head>
<title>Roam</title>
</head>
<body style="background-color: khaki;">
HEADER;

echo "<h2>Welcome to {$locinfo['name']}</h2>";
echo "<h5>{$locinfo['description']}</h5>";

echo "<div style=\"position:relative;left:25px;background-color: goldenrod; width: 300px;\">\n";
echo "<span style=\"position:relative; left:4px;\"><h3>The following people are here:</h3></span>";
echo "<ul>";
$people = getPeopleListResult( $locinfo['id'] );
while( $person = mysql_fetch_array( $people ) ) {
	$person_info = getPersonById( $person['person_id'] );
	echo "<li>{$person_info['name']}</li>";
}
echo "</ul><br>\n";
echo "</div>\n";

echo "<div style=\"position:relative;left:25px;background-color:sandybrown; width: 300px;\">\n";
echo "<span style=\"position:relative; left:4px;\"><h3>Paths</h3></span>\n";
echo "<table style=\"table-layout:fixed; position:relative; left:8px;\">\n";
$result = getPathsListByLocId( $currentloc );
while( $path = mysql_fetch_array( $result ) ) {
	$pathToId = $path['id'];
	$pathToName = $path['name'];
	$distance =$path['distance'];
	$button = createButtonLink( $pathToId, $personId );
	echo 
	   "<tr height=\"20\" style=\"max-height=12pt;\">
		<td width=\"120\" style=\"vertical-align: top;\"><b>{$pathToName}</b></td>
		<td width=\"60\"  style=\"vertical-align: top;\">{$distance} days</td>
		<td width=\"40\">{$button}</td></tr>\n";
}
echo "</div>\n";
?>
</body>
</html>