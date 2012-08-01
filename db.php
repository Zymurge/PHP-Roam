<?php

define( "MYSQL_DUPLICATE_KEY", 1062 );

function connectDB( $server, $user, $pass, $db ) {
	mysql_connect( $server, $user, $pass ) or die(mysql_error());
	mysql_select_db( $db ) or die(mysql_error());
}

function connectRoam() {
	connectDB( "localhost", "root", "", "roam" );
}

function getQueryResult( $query ) {
	if ( $result = mysql_query( $query ) ) {
		return $result;
	} else {
		$e = new Exception();
		$trace = $e->getTrace();
		//position 1 in stack trace is the calling method
		$caller = $trace[1]['function'];
		die( "<i>{$caller}</i>: " . mysql_error() . "<br><i>Query</i>: $query" );
	}
}

function addNewUser( $name, $description, $location_id ) {
	$insert = "INSERT into people ( name, description ) VALUES ( \"$name\", \"$description\" ) ;";
	$result = mysql_query( $insert );
	if( ! $result ) {
		if( mysql_errno() == MYSQL_DUPLICATE_KEY ) {
			return false;
		} else {
			die( "<i>addNewUser</i>: " . mysql_error() . "<br><i>Query</i>: $insert" );
		}
	}
	$person = getPersonByName( $name );
	$person_id = $person['id'];
	$result = getQueryResult( "INSERT into people_map ( person_id, location_id ) VALUES ( '$person_id', '$location_id' ) ;" );
	return $person;
}

function getLocationById( $loc_id ) {
	$result = getQueryResult( "SELECT * FROM locations WHERE id = $loc_id ;" );
	$locinfo = mysql_fetch_array( $result );
	return $locinfo;
}

function getLocationByPerson( $person_id ) {
	$result = mysql_query( "SELECT * FROM people_map WHERE person_id = $person_id ;" ) or die( mysql_error() );
	$person = mysql_fetch_array( $result );
	return $person;
}

function getPathsListByLocId( $loc_id ) {
	$result = getQueryResult( 
		"SELECT locations.name, locations.id, paths.distance 
		   FROM paths, locations 
		  WHERE ( paths.node1 = $loc_id and locations.id = paths.node2 )
		     OR ( paths.node2 = $loc_id and locations.id = paths.node1 );" );
	return $result;
}

function getPeopleListResult( $loc_id ) {
	$result = mysql_query( "SELECT * FROM people_map WHERE location_id = $loc_id ;" ) or die( mysql_error() );
	return $result;
}

function getPersonById( $person_id ) {
	$result = getQueryResult( "SELECT * FROM people WHERE id = $person_id ;" );
	$person = mysql_fetch_array( $result );
	return $person;
}

function getPersonByName( $name ) {
	$result = getQueryResult( "SELECT * FROM people WHERE name = \"$name\" ;" );
	if( $rows = mysql_num_rows( $result ) > 0 ) {
		$person= mysql_fetch_array( $result ) or die( "getPersonByName-mysql_fetch_array: " . mysql_error() );
		return $person;
	} else {
		return false;
	}
}
	
function pathLink( $locationId, $personId ) {
	$form = "\n<form action=\"processMove.php\" method=\"post\">
		<input name=\"person\" value=\"$personId\" type=\"hidden\" />
		<input name=\"moveTo\" value=\"$locationId\" type=\"hidden\" />
		<input type=\"submit\" value=\"Go\" />
		</form>";

	return $form;
}

function randomLocationId() {
	$result = getQueryResult( "SELECT * FROM locations WHERE 1 ORDER BY RAND() LIMIT 1 ;" );
	$locinfo = mysql_fetch_array( $result );
	return $locinfo['id'];
}

function setPersonLocation( $user_id, $loc_id ) {
	$result = getQueryResult( "UPDATE people_map SET location_id = $loc_id WHERE person_id = $user_id ;" );
	return $result;
}

?>