<?php
require 'db.php';
connectRoam();

$personId = $_POST['person'];
$moveToId = $_POST['moveTo'];
setPersonLocation( $personId, $moveToId );
$url = "http://localhost/roam/location.php?user={$personId}";
header( "Location: " . $url );

?>
