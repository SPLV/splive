<?php

$cURL = curl_init('195.33.216.91'); //Initialise cURL with the URL to connect to
curl_setopt($cURL, CURLOPT_PORT, 80); //Set the port to connect to
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true); //Get cURL to return the HTML from the curl_exec function

$HTML = curl_exec($cURL); //Execute the request and store the result in $HTML

echo $HTML; //Output the HTML