<?php
	include "database.php";

	$func = $_POST['f']; // Check what function to apply
	
	/* Returns the correct query to update the rating given a rating $r, an
	 * action ("A(dd)" or "D(elete)"), and the list ID $lid. */
	function updateRating($r, $a, $lid) {
		if ((($r == 1) and ($a == "A")) or (($r == 0) and ($a == "D"))) {
			return "UPDATE listings SET rating = rating + 1 WHERE listid = $lid";
		} elseif ((($r == 1) && ($a == "D")) || (($r == 0) && ($a == "A"))) {
			return "UPDATE listings SET rating = rating - 1 WHERE listid = $lid";
		}
	}
	
	/* Add or remove a rating for a listing. */
	if ($func == "rate") {
		$user = $_POST['username'];
		$rating = $_POST['rating'];
		$listid = $_POST['listid'];
		$action = $_POST['action'];
		$modifyRating = updateRating($rating, $action, $listid);
		
		if ($action == 'A') { // Add a new rating to the listing.
			$insertRating = "INSERT INTO postrated VALUES ('$user', $listid, $rating)";
			querydb($insertRating);
		} elseif ($action == 'D') { // Delete a rating for the listing.
			$deleteRating = "DELETE FROM postrated WHERE username = '$user' AND listid = $listid";
			querydb($deleteRating);
		}
		querydb($modifyRating);
	}
	
	/* Delete a listing. */
	if ($func == "delete") {
		$listid = $_POST['listid'];
		querydb("DELETE FROM postrated WHERE listid = $listid");
		querydb("DELETE FROM posted WHERE listid = $listid");
		querydb("DELETE FROM tenant WHERE listid = $listid");
		querydb("DELETE FROM listings WHERE listid = $listid");
	} 

	echo "$func";

?>