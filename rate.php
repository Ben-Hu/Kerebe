<?php
	session_start();
	$action = $_POST['action'];
	$curruser = $_SESSION['username'];
	$id = $_POST['listid'];
	$modify = $_POST['modify'];

	$conn = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
	$dbconn = pg_connect($conn);

	


	if ($modify == 'A') { // The user has not rated the listing before

		if ($action == 'Y') {
			$modifyRating = "UPDATE listings SET rating = rating + 1 WHERE listid = $id";
		} else {
			$modifyRating = "UPDATE listings SET rating = rating - 1 WHERE listid = $id";
		}
		$insertRated = "INSERT INTO postrated VALUES ('$curruser', $id, '$action')";
		// pg_query($dbconn, $modifyRating);
		pg_query($dbconn, $insertRated);
	}
	else if ($modify == 'D') {
		// Check if the user has liked or disliked this listing
		$rated = pg_query($dbconn, "SELECT liked FROM postrated WHERE username='$curruser' AND listid = $id");
		$fetchRow = pg_fetch_row($rated); // Get the row if it was rated
		$deleteRating = "DELETE FROM postrated WHERE username = '$curruser' AND listid = $id";
		$likeornot = $fetchRow[0];
		if ($likeornot == 'Y') {
			$modifyRating = "UPDATE listings SET rating = rating - 1 WHERE listid = $id";
		} else {
			$modifyRating = "UPDATE listings SET rating = rating + 1 WHERE listid = $id";
		}
		pg_query($dbconn, $deleteRating); 
	}
	pg_query($dbconn, $modifyRating);
	pg_close($dbconn);

?>