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
$result = mysql_query( "SELECT * FROM paths WHERE node1 = $currentloc ;" ) or die( mysql_error() );
while( $paths = mysql_fetch_array( $result ) ) {
	$pathToId = $paths['node2'];
	$button = pathLink( $pathToId, $personId );
	echo "<tr><td>{$button}</td><td>{$paths['distance']} days</td></tr>";
}
$result = mysql_query( "SELECT * FROM paths WHERE node2 = $currentloc ;" ) or die( mysql_error() );
while( $paths = mysql_fetch_array( $result ) ) {
	$pathToId = $paths['node1'];
	$button = pathLink( $pathToId, $personId);
	echo "<tr><td>{$button}</td><td>{$paths['distance']} days</td></tr>";
}
?>
</body>
</html>