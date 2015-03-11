<?php
	$curruser = $_GET['user'];
	
	// Get friends of the current user
	$getFriends = "SELECT friend FROM friends WHERE username='$curruser'";
	$friends = querydb($getFriends);

	// Get information about the current user
	$info = "SELECT * FROM users WHERE username='$curruser'";
	$getInfo = querydb($info);
	$userInfo = pg_fetch_row($getInfo);
?>