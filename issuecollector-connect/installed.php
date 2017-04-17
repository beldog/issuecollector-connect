<?php 
$MODULE = "[INSTALL]";
// error_log($MODULE.'server:'.print_r($_server, true));
// error_log($MODULE.'GET:'.print_r($_GET, TRUE));

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
     * payload TEXT
	 * time INTEGER
	 */
	
	$query = "INSERT INTO payloads (clientKey, payload, time) VALUES ('".$data->{'clientKey'}."', '$payload', 0)";
	error_log( $MODULE.'Database to be updated with: '.  $data->{'clientKey'} .'/'. $query .'\r\n');
	
	$database->exec($query);
	error_log( $MODULE.'Database updated with: '.  $data->{'clientKey'} .'\r\n');
	
	//list current clients
	foreach ($database->query("SELECT * FROM payloads") as $row) {
		error_log( $MODULE.'Database:'.print_r($row));
	}
	
	// Close file db connection
	$database = null;
	
	/* 
	 * Registering webhooks
	 */
	$restUrl = "https://***/rest/webhooks/1.0/webhook";
	
	$data = '{
			"name": "Cascade Epic details",
			"events": ["jira:issue_updated"],
			"url": "https://nuevegen.net/jira/issuecollector-connect/cascade-epic-details.php?issuekey=${issue.key}&projectkey=${project.key}",
			"excludeBody": false,
			"filters": {"issue-related-events-section": "project = GR and issuetype=Epic"}
	}';
	
	$username = 'admin';
	$password = '***';
	
	$curl_url = $restUrl;
	
	$ch = curl_init ();
	$headers = array (
			'Accept: application/json',
			'Content-Type: application/json'
	);
	
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $ch, CURLOPT_VERBOSE, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt ( $ch, CURLOPT_URL, $curl_url );
	curl_setopt ( $ch, CURLOPT_USERPWD, "$username:$password" );
	
	$result = curl_exec ( $ch );
	$ch_error = curl_error ( $ch );
	
	if ($ch_error) {
		error_log ( $MODULE . 'cURL Error: ' . print_r ( $ch_error, TRUE ) );
	} else {
		error_log($MODULE.'cURL Result: '.print_r($result, TRUE));
	}
	
	curl_close ( $ch );
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