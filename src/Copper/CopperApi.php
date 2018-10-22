<?php
namespace Copper;

class CopperApi
{
	private $apiKey;
	private $application;
	private $devEmail;

    public function __construct($apiKey, $application, $devEmail)
    {
    	$this->apiKey = $apiKey;
    	$this->application = $application;
    	$this->devEmail = $devEmail;
    }

    public function copperConnect($dataCall, $callType, $callFields)
    {
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.prosperworks.com/developer_api/v1/$dataCall",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => $callType,
			  CURLOPT_POSTFIELDS => $callFields,
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/json",
			    "X-PW-AccessToken: ".$this->apiKey,
			    "X-PW-Application: ".$this->application,
			    "X-PW-UserEmail: ".$this->devEmail
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			  die();
			} else {
			  return $response;
			}
    }
}
