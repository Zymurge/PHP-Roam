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
<body>
HEADER;

echo "<h2>Welcome to {$locinfo['name']}</h2>";
echo "<h5>{$locinfo['description']}</h5>";

echo "<p><h5>The following people are here:</h5>";
echo "<ul>";
$people = getPeopleListResult( $locinfo['id'] );
while( $person = mysql_fetch_array( $people ) ) {
	$person_info = getPersonById( $person['person_id'] );
	echo "<li>{$person_info['name']}</li>";
}
echo "</ul>";

echo "<p><h5>Paths</h5>";
echo "<table>";
$result = getPathsListByLocId( $currentloc );
while( $path = mysql_fetch_array( $result ) ) {
	$pathToId = $path['id'];
	$pathToName = $path['name'];
	$distance =$path['distance'];
	$button = pathLink( $pathToId, $personId );
	echo "<tr><td>{$pathToName}</td><td>{$distance} days</td><td>{$button}</td></tr>";
}
?>
</body>
</html>