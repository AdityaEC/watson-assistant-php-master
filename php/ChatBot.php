<?php
/*
 * API: ChatBot ©
 * Features: sends and retrieves messages from / to Watson Assistant via cURL
 * References: https://www.ibm.com/watson/developercloud/assistant/api/v1/
 * Author: Luca Crippa - luca.crippa88@gmail.com
 * Date: April 2018
 */

  if(isset($_POST['message'])){

    // INSERT WATSON ASSISTANT DATA HERE

    // ID of Watson Assistant Workspace
    $workspace_id = '6115f820-eaeb-433a-ae34-3e07a6c35d25';
    // Release date of the API version in YYYY-MM-DD format (*)
    $release_date = '2018-10-25';
    // Username of the service credentials
    $username = 'e26b61c7-7044-4897-8d9d-8206ce263012';
    // Password of the service credentials
    $password = 'FcmS3YUA3OLZ';

    // (*) Release date allows you to use an older version of the Watson Assistant API, to have compatibility cross releases

    // Make a request message for Watson API in json
    $data['input']['text'] = $_POST['message'];
    if(isset($_POST['context']) && $_POST['context']){
      $data['context'] = json_decode($_POST['context'], JSON_UNESCAPED_UNICODE); // Encode multibyte Unicode characters literally (default is to escape as \uXXXX)
    }
    $data['alternate_intents'] = false;

    // Encode json data
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);

    // Post the json to Watson Assistant API via cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://gateway.watsonplatform.net/assistant/api/v1/workspaces/'.$workspace_id.'/message?version='.$release_date); // Instructions here: https://www.ibm.com/watson/developercloud/assistant/api/v1/curl.html?curl#message
    curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password); // Set cURL Watson Assistant credentials
    curl_setopt($ch, CURLOPT_POST, true );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Set cURL headers
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

    // Prepare response, close cURL and send response to front-end
    $result = trim(curl_exec($ch)); // Prepare
    curl_close($ch); // Close
    echo json_encode($result, JSON_UNESCAPED_UNICODE); // Send
  }

?>
