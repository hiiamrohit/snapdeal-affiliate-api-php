<?php
/*
* Author: Rohit Kumar
* Website: iamrohit.in
* Version: 0.0.1
* Date: 7-02-2016
* App Name: Snapdeal Affiliate Api
* Description: Simple Snapdeal api in php to create your online deals or e-commerce affiliate market place 
*/
 class snapdealApi {
   
    private static $affiliateID;

    private static $token;

    private static $timeout = 45;

    //Set snapdeal affilate id and token at the time of class init.

     public function __construct($affiliateID, $token) {
       self::$affiliateID = $affiliateID;
       self::$token = $token;
      }


     public static function getData($url, $dataType) {

         try {

         	if(!isset($url) && !empty($url)) {
         		throw new exception("URL is not available.");
         	}

         	if(!isset($dataType) && !empty($dataType)) {
         		throw new exception("Please set datatype json or xml");
         	}

         	if (!function_exists('curl_init')){
                throw new exception("Curl is not available.");
         	}
         	 // Set header to make authentication
	        $headers = array(
	            'Accept:application/'.$dataType,
	            'Snapdeal-Affiliate-Id: '.self::$affiliateID,
	            'Snapdeal-Token-Id:: '.self::$token
	            );

	        $cObj = curl_init();
	        curl_setopt($cObj, CURLOPT_URL, $url);
	        curl_setopt($cObj, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($cObj, CURLOPT_TIMEOUT, self::$timeout);
	        curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
	        $result = curl_exec($cObj);
	        curl_close($cObj);
             // render result as per format.
             
              if($dataType == 'json') {
               return $result ? json_decode($result, true) : false;
             } else if($dataType == 'xml') {
                return $result ? new SimpleXMLElement($result) : false;
             } else {
              return false;
             }

         }  catch (Exception $e) {
            return $e->getMessage();
         }
      }


 }






?>
