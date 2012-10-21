<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
session_start();

$toDir = "./webcamtemp/";
$filename = $_SESSION['joz_account']['id_user'].'_'.md5(date('YmdHis')).'.jpg';

$result = file_put_contents( $toDir.$filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

//$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $filename;
$image = $filename;
print "{$image}|ok";

exit;
?>