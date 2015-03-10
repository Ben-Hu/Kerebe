<?php
	session_start();
	
	/* Return the result of a database query. */
	function querydb($query) {
		$connString = "host=csc309instance2.cuw3cz9voftq.us-west-2.rds.amazonaws.com port=5432 dbname=SynergySpace user=CSC309Project password=309kerebe";
		$dbconn = pg_connect($connString);
		$result = pg_query($dbconn, $query);
		pg_close($dbconn);
		return $result;
	}
?>