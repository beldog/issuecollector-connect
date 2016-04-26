<?php 
try {

	// Create (connect to) SQLite database in file
	$file_db = new PDO('sqlite:issuecollector.sqlite3');
	// Set errormode to exceptions
	$file_db->setAttribute(PDO::ATTR_ERRMODE,
			PDO::ERRMODE_EXCEPTION);
	
	// Create table messages
	$file_db->exec("CREATE TABLE IF NOT EXISTS payloads (
                    clientKey TEXT PRIMARY KEY,
                    payload TEXT,
					time INTEGER)");

	// Drop table messages from file db
	//$file_db->exec("DROP TABLE payloads");
	
	// Close file db connection
	$file_db = null;
}
catch(PDOException $e) {
	// Print PDOException message
	echo $e->getMessage();
}
?>