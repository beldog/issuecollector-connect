<?php 
$MODULE = "[TRIGGERED]";
error_log($MODULE.'GET:'.print_r($_GET, TRUE));

$payload = file_get_contents('php://input');
$data = json_decode($payload);
error_log( $MODULE.'Payload: '.print_r($data, TRUE));

$restUrl = "https://***REMOVED***/rest/api/2";

try {
/* LOAD data from DB to generate JWT access token instead of HTTP BASE credentials*/
	
// 	// Create (connect to) SQLite database in file
// 	$database = new PDO('sqlite:issuecollector.sqlite3','','', array(
//                 PDO::ATTR_PERSISTENT => true
//             ));
// 	// Set errormode to exceptions
// 	$database->setAttribute(PDO::ATTR_ERRMODE,
// 			PDO::ERRMODE_EXCEPTION);

// 	error_log( $MODULE.'Database opened...'.'\r\n');
// 	/*
// 	 * Table structure:
// 	 * clientKey TEXT PRIMARY KEY
//   * payload TEXT
// 	 * time INTEGER
// 	 */
	
// 	$query = "SELECT payload FROM payloads WHERE clientKey='...'";	
// 	$database->exec($query);
	
// 	//list current clients
// 	foreach ($database->query("SELECT * FROM payloads") as $row) {
// 		error_log( $MODULE.'Database:'.print_r($row));
// 	}
	
// 	// Close file db connection
// 	$database = null;

	/* AUTHENTITICATION: HTTP simple base*/
	$username = 'admin';
	$password = '***REMOVED***';
	
	
	/* Extracting all linked issues*/
	$searchUrl = "/search?jql=";
	$searchLinkedIssues = $searchUrl."cf[10004]=". $_GET["issuekey"];
	
	$curl_url = $restUrl.$searchLinkedIssues;
	
	// $data = array(
	// 		'fields' => array(
	// 				'project' => array(
	// 						'key' => 'xxx',
	// 				),
	// 				'summary' => 'This is summary',
	// 				'description' => 'This is description',
	// 				"issuetype" => array(
	// 						"self" => "xxxx",
	// 						"id" => "xxxx",
	// 						"description" => "xxxxx",
	// 						"iconUrl" => "xxxxx",
	// 						"name" => "xxxx",
	// 						"subtask" => false
	// 				),
	// 		),
	// );
	
	
	$ch = curl_init();
	$headers = array(
			'Accept: application/json',
			'Content-Type: application/json'
	);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_URL, $curl_url);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	
	$result = curl_exec($ch);
	
	$ch_error = curl_error($ch);
	
	if ($ch_error) {
		error_log($MODULE.'cURL Error: '.print_r($ch_error, TRUE));
	} else {
		error_log($MODULE.'cURL Result: '.print_r($result, TRUE));
	}
	
	curl_close($ch);
	
	//extracting linked issues
	$linkedIssuesData = json_decode($result, true, 4);
	foreach ($linkedIssuesData->issues as $linkedIssue) {
		error_log( $MODULE.'Issue :'.$linkedIssue->{'key'} . "/". $linkedIssue->{'status'}->{'name'} ."/". $linkedIssue->{'status'}->{'statusCategory'}->{'name'});
	}
	
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