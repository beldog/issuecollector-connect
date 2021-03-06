<?php 
$MODULE = "[UNINSTALL]";
// error_log( $MODULE.'SERVER:'.print_r($_SERVER, TRUE));
// error_log( $MODULE.'GET:'.print_r($_GET, TRUE));

$payload = file_get_contents('php://input');
$data = json_decode($payload);

error_log( $MODULE.'Payload:'.print_r($data, TRUE));

try {

	// Create (connect to) SQLite database in file
	$database = new PDO('sqlite:issuecollector.sqlite3','','', array(
                PDO::ATTR_PERSISTENT => true
            ));
	// Set errormode to exceptions
	$database->setAttribute(PDO::ATTR_ERRMODE,
			PDO::ERRMODE_EXCEPTION);

	error_log( $MODULE.'Database opened...'.'\r\n');
	/*
	 * Table structure:
	 * clientKey TEXT PRIMARY KEY
     * payload BLOB
	 * time INTEGER
	 */
	
	$query = "DELETE FROM payloads WHERE clientKey='".$data->{'clientKey'}."'";
	error_log( $MODULE.'Database to be updated with: '.  $data->{'clientKey'} .'/'. $query .'\r\n');
	
	$database->exec($query);
	error_log( $MODULE.'Database updated with: '.  $data->{'clientKey'} .'\r\n');
	
	//list current clients
	foreach ($database->query("SELECT * FROM payloads") as $row) {
		error_log( $MODULE.'Database:'.print_r($row));
	}
	
	// Close file db connection
	$database = null;
}
catch(PDOException $e) {
	// Print PDOException message
	error_log( $MODULE.'ERROR:'.print_r($e->getMessage(), TRUE) .'\r\n');
	error_log( $MODULE.'ERROR-Code:'.print_r($e->getCode(), TRUE) .'\r\n');
	$database = null;
}
catch(Exception $e) {
	// Print Exception message
	error_log( $MODULE.'ERROR:'.print_r($e->getMessage(), TRUE) .'\r\n');
	error_log( $MODULE.'ERROR-Code:'.print_r($e->getCode(), TRUE) .'\r\n');
	$database = null;
}

?>