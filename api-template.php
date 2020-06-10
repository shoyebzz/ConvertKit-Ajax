<?php

/**
 * Template Name: Api Request
 * Author: Mashiur Rahman
 * Author URI: mashiurz.com
 */

if(isset($_POST['form_id'])){

    if( !empty($_POST['usr_email']) 
        && !empty($_POST['usr_name']) 
        && $_POST['tosagree'] == 'on' ){

        $email = $_POST['usr_email'];
        $name = $_POST['usr_name'];
        $formID = $_POST['form_id']; //1438994
        $tags = isset($_POST['form_tag']) ? $_POST['form_tag'] : ''; //1571557
    
        $postRequest = array(
            'api_key' => 'VikL3dTmJPL_i5IuES4REw',
            'email' => $email,
            'first_name' => $name,
            'tags' => $tags, // enter the tag id here
        );
        
        $cURLConnection = curl_init("https://api.convertkit.com/v3/forms/{$formID}/subscribe");
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, json_encode($postRequest));
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
        ));
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        
        // $apiResponse - available data from the API request
        $jsonArrayResponse = json_decode($apiResponse);


        if(isset($jsonArrayResponse->subscription)){

            if( $jsonArrayResponse->subscription->state == "active"){

                $sucsError = "Sucessfully sbscribed!";

            } 
            
            if ( $jsonArrayResponse->subscription->state == "cancelled"){

                $sucsError = "Sucessfully unsbscribed!";

            }
            
        } else {

            $sucsError = $jsonArrayResponse->message;

        }

        //echo $sucsError;

    }else{
        $sucsError = "Please fillup all those fields!";
    }

    if(isset($sucsError)){
        echo $sucsError;
    }

}

?>