<?php
require 'db.php';
connectRoam();

$action = $_POST['action'];
$url = "";
switch( $action ) {
	case "enter": 
		$name = $_POST['name'];
		$person = getPersonByName( $name );
		if( $person == false ) {
			$url = "http://localhost/roam/enter.php?retry=1";
		}
		break;
	case "register":
		# do some stuff
		$name = $_POST['name'];
		$description = $_POST['description'];
		if( ! $person = addNewUser( $name, $description, randomLocationId() ) ) {
			echo "User '{$name}' already taken.";
			echo "<p><a href=\"register.php\">Try again</a>";
			exit();
		}
		break;
}
if( ! isset( $person ) ) die( "Exiting process enter.php without person set" );
if( $url == "" ) { $url = "http://localhost/roam/location.php?user={$person['id']}"; }
header( "Location: " . $url );
echo "URL string: $url";

?>
