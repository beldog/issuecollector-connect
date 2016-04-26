<?php 
$MODULE = "[INSTALL]";
// file_put_contents('php://stderr', $MODULE.'server:'.print_r($_server, true));
// file_put_contents('php://stderr', $MODULE.'GET:'.print_r($_GET, TRUE));

$payload = file_get_contents('php://input');
$data = json_decode($payload);

file_put_contents('php://stderr', $MODULE.'Payload:'.print_r($data, TRUE));

try {

	// Create (connect to) SQLite database in file
	$database = new PDO('sqlite:issuecollector.sqlite3','','', array(
                PDO::ATTR_PERSISTENT => true
            ));
	// Set errormode to exceptions
	$database->setAttribute(PDO::ATTR_ERRMODE,
			PDO::ERRMODE_EXCEPTION);

	file_put_contents('php://stderr', $MODULE.'Database opened...'.'\r\n');
	/*
	 * Table structure:
	 * clientKey TEXT PRIMARY KEY
     * payload TEXT
	 * time INTEGER
	 */
	
	$query = "INSERT INTO payloads (clientKey, payload, time) VALUES ('".$data->{'clientKey'}."', '$payload', 0)";
	file_put_contents('php://stderr', $MODULE.'Database to be updated with: '.  $data->{'clientKey'} .'/'. $query .'\r\n');
	
	$database->exec($query);
	file_put_contents('php://stderr', $MODULE.'Database updated with: '.  $data->{'clientKey'} .'\r\n');
	
	//list current clients
	foreach ($database->query("SELECT * FROM payloads") as $row) {
		file_put_contents('php://stderr', $MODULE.'Database:'.print_r($row));
	}
	
	// Close file db connection
	$database = null;
}
catch(PDOException $e) {
	// Print PDOException message
	file_put_contents('php://stderr', $MODULE.'ERROR:'.print_r($e->getMessage(), TRUE) .'\r\n');
	file_put_contents('php://stderr', $MODULE.'ERROR-Code:'.print_r($e->getCode(), TRUE) .'\r\n');
	$database = null;
}
catch(Exception $e) {
	// Print Exception message
	file_put_contents('php://stderr', $MODULE.'ERROR:'.print_r($e->getMessage(), TRUE) .'\r\n');
	file_put_contents('php://stderr', $MODULE.'ERROR-Code:'.print_r($e->getCode(), TRUE) .'\r\n');
	$database = null;
}

?>