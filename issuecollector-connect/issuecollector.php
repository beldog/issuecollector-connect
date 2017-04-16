<?php

$data = null;
$clientJWT = $_GET['jwt'];
try {
	$MODULE = "[VIEW]";
	error_log( $MODULE.'Client JWT: '.$clientJWT.'\r\n');
	
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

	//list current clients
	foreach ($database->query("SELECT payload FROM payloads") as $row) {
		$data = json_decode($row['payload']);
		//error_log( $MODULE.'Extracted data:'.print_r($data));
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

<html>
    <head>
        <!-- External dependencies -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/sinon.js/1.15.4/sinon.js"></script>
        <script src="//aui-cdn.atlassian.com/aui-adg/5.9.17/js/aui.js"></script>
        <script src="//aui-cdn.atlassian.com/aui-adg/5.9.17/js/aui-experimental.js"></script>
        <script src="//aui-cdn.atlassian.com/aui-adg/5.9.17/js/aui-datepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="//aui-cdn.atlassian.com/aui-adg/5.9.17/css/aui.css"/>
        <link rel="stylesheet" type="text/css" href="//aui-cdn.atlassian.com/aui-adg/5.9.17/css/aui-experimental.css"/>
         <script src="//nuevegen.atlassian.net/atlassian-connect/all.js" type="text/javascript"></script>
         
         <script src="external/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/sinon.js/1.15.4/sinon.js"></script>
        <script src="//aui-cdn.atlassian.com/aui-adg/5.9.17/js/aui.js"></script>
        <script src="//aui-cdn.atlassian.com/aui-adg/5.9.17/js/aui-experimental.js"></script>
        <script src="//aui-cdn.atlassian.com/aui-adg/5.9.17/js/aui-datepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="//aui-cdn.atlassian.com/aui-adg/5.9.17/css/aui.css"/>
        <link rel="stylesheet" type="text/css" href="//aui-cdn.atlassian.com/aui-adg/5.9.17/css/aui-experimental.css"/>
         <script src="//nuevegen.atlassian.net/atlassian-connect/all.js" type="text/javascript"></script>
        <!-- / External dependencies -->
    </head>
    <body>
        <section id="content" class="ac-content">
      <div class="aui-page-header">
             <div class="aui-page-header-main">
          <h1>Issue Collector</h1>
        </div>
          </div>

      <div class="aui-tabs horizontal-tabs">
            <ul class="tabs-menu">
                <li class="menu-item active-tab">
                    <a href="#tabs-example-first">Operations</a>
                </li>
                <li class="menu-item">
                    <a href="#tabs-example-second">Acquisition</a>
                </li>
              <li class="menu-item">
                    <a href="#tabs-example-third">SugarCRM</a>
                </li>
            </ul>
            <div class="tabs-pane active-pane" id="tabs-example-first">
               <br/><div class="aui-group"> 
              <button class="aui-button aui-lozenge-complete">Billing logic</button>
              <button class="aui-button aui-lozenge-complete">Dormant logic</button> 
              <button class="aui-button aui-lozenge-complete">Messaging configuration</button>
              <button class="aui-button aui-lozenge-complete">New/Change logic</button> 
              <button class="aui-button aui-lozenge-complete">Redemption sites</button>
              </div>
              <div class="aui-group"> 
              <button class="aui-button aui-lozenge-error">Cube Discrepancies</button>  
              <button class="aui-button aui-lozenge-error">Log investigation</button>  
              <button class="aui-button aui-lozenge-error">Other support</button>
              <button class="aui-button aui-lozenge-error">Renew Issue</button>
              <button class="aui-button aui-lozenge-error">Revenue Assurance</button>
              <button class="aui-button aui-lozenge-error">User data extraction</button>
              </div>
            </div>
            <div class="tabs-pane" id="tabs-example-second">
                <br/><div class="aui-group"> 
              <button class="aui-button aui-lozenge-complete">Change on LP Master Template</button>  
              <button class="aui-button aui-lozenge-complete">Configuration change</button>  
              <button class="aui-button aui-lozenge-complete">New/Change logic</button>
              </div>
              <div class="aui-group"> 
              <button class="aui-button aui-lozenge-error">Affiliate Pixel</button>  
              <button class="aui-button aui-lozenge-error">Alterative Domain</button>  
              <button class="aui-button aui-lozenge-error">Error on live traffic</button>  
              <button class="aui-button aui-lozenge-error">Log investigation</button>  
              <button class="aui-button aui-lozenge-error">LP Design Issue</button>
              <button class="aui-button aui-lozenge-error">Performance Investigation</button>
              <button class="aui-button aui-lozenge-error">Stats Discrepancy</button>
                 </div>
            </div>
          <div class="tabs-pane" id="tabs-example-third">
                <br/><div class="aui-group"> 
              <button class="aui-button aui-lozenge-error">General request</button>
            </div>
        </div>
      <form class="aui top-label" id="issuecollector" action="#">
        <select class="full-width-field" id="select2-example" multiple="" placeholder="Country/s">
            <option value="UK">United Kingdom</option>
            <option value="DE">Germany</option>
            <option value="CH">Switzerland</option>
            <option value="UAE">Emirates</option>
            <option value="AT">Austria</option>
            <option value="RU">Russia</option>
            <option value="ZA">South Africa</option>
            <option value="SG">Singapore</option>
          <option value="AU">Australia</option>
          <option value="MY">Malaysia</option>
          <option value="IN">India</option>
          <option value="VN">Vietnam</option>
          <option value="IT">Italy</option>
          <option value="TR">Turkey</option>
          <option value="GR">Greece</option>
          <option value="ES">Spain</option>
          <option value="PT">Portugal</option>
          <option value="AR">Argentina</option>
          <option value="BR">Brazil</option>
          <option value="CL">Chile</option>
          <option value="MX">Mexico</option>
        </select>

        <div class="aui-group">
          <input class="text full-width-field" type="text"
               id="subject" name="subject" placeholder="You request subject">        
        </div>
    
        <div class="aui-group">
        
        <textarea class="textarea full-width-field" name="description"
                  id="description" placeholder="Your comment here..." rows="5"></textarea>
        </div>
          <div class="aui-group">
            <label class="full-width-field ffi" data-ffi-button-text="Attach file">
                    <input type="file" id="ffi1" name="ffi1" aria-label="Fancy File Input">
                </label>
        </div>
          
          <div class="aui-group">
            <div class="aui-item">    
            <aui-label for="deadline-input">External deadline?</aui-label>
                <aui-toggle id="deadline-input" label="External deadline" tooltip-on="Yes" tooltip-off="No"></aui-toggle>
            </div>
            <div class="aui-item">
            <aui-label for="revenueloss-input">Revenue loss?</aui-label>
            <aui-toggle id="revenueloss-input" label="Revenue loss" tooltip-on="Yes" tooltip-off="No"></aui-toggle>
            </div>
          </div>
          
          <div class="buttons-container">
        <div class="buttons">
            <input class="button submit" type="submit" value="Save" id="comment-save-button">
            <a class="cancel" href="#">Cancel</a>
        </div>
    </div>
        </form>
        </section>
        <script>
        AJS.$("#select2-example").auiSelect2();

        AJS.$('#description').blur(function() {
          var val = this.value;
          if ( val.indexOf('deadline') !== -1 ) {
            AJS.$('#deadline-input').attr('checked', true);        
          }
        });
        
        /* Logic */
        AJS.$("#issuecollector").submit(function(event){
        	var host = '';
        	var issue_browse = host +"/browse/";
        	var countries_lmn = ['CH', 'AT', 'UAE']
        	
        	
        	//defaut project
        	project = "SOP";
        	issuetype = "Story";

        	summary = AJS.$('#subject').val();
        	description = AJS.$('#description').val();
        	
        	var labels = [];
//             AJS.$('#country .active').each(function(){
//                 labels.push(AJS.$(this).attr('id'));
//                 if(jQuery.inArray(AJS.$(this).attr('id'), countries_lmn) >= 0){
//                 	//country under LMN
//                 	labels.push("LMN"); 
//                 	project = 'PPE';
//                 }
//             });
            
//             AJS.$('#request .active').each(function(){
//                 labels.push(AJS.$(this).attr('id')); 
//                 if (AJS.$(this).hasClass("support")){
//                 	labels.push("Support");
//                 	issuetype = 'Bug';
//                 }
//                 else if (AJS.$(this).hasClass("evolution")){
//                 	labels.push("Evolution");
//                 }
                
//                 if (AJS.$(this).hasClass("GAS")){
//                 	project = 'GAS';
//                 }
//             });
            
        	AJS.$.ajax({
        		url: host +'/rest/api/2/issue/',
        		type: 'POST',
        		dataType: 'json',
        		contentType: "application/json",
        		data: JSON.stringify({
        			"fields": {
        				"project": { 
        					"key": project
        				},
        				"summary": summary,
        				"description": description,
        				"issuetype": {
        					"name": issuetype
        				},
        				"labels": labels
        			}
        		}),
        		error: function(response){
        			console.log('error, args:'+ response);
        			$('#submitresult').append(JSON.stringify(response));
        		},
        		success: function (response){
        			console.log("Request created: "+ JSON.stringify(response));
        			$('#submitresult').append('<p><a href="'+ issue_browse + response.key +'">'+ issue_browse + response.key +'</a></p>');
        			$('#submitresult').append('<p>'+ JSON.stringify(response) +'</p>');
        		}
        	});

        	event.preventDefault();
        });
        </script>
    </body>
</html>