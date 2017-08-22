<?php
session_start();
require_once 'app/Mage.php';
Mage::app();
$baseUrl = str_replace("get_token.php/","",Mage::getBaseUrl());

echo $baseUrl;
$n_client_id = '1e4aed307ece4fcf98a60fb6d8c499ff';
$n_client_secret = '037baeb710bc493abdfa57269b7a876d';
$n_redurect_uri = $baseUrl .'instagram/return.php';
 
date_default_timezone_set('UTC');
$code = "772d50863cfe4a7b9e5a88cb7008bdd3"; // get Code from:
$url = "https://api.instagram.com/oauth/access_token";
$access_token_parameters = array(
    'client_id'     => $n_client_id,
    'client_secret' => $n_client_secret,
    'grant_type'    => 'authorization_code',
    'redirect_uri'  => $n_redurect_uri,
    'code'          => $code
);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_parameters);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
 var_dump($result);
$authObj = json_decode($result);
echo $authObj->access_token;
