<?php

// Create a function to fetch data from the API
function fetchData($url) {
  // Initialize a curl session
  $ch = curl_init();
  
  // Set the URL and other options
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, false);
  
  // Execute the curl session and store the response
  $response = curl_exec($ch);
  
  // Close the curl session
  curl_close($ch);
  
  // Return the response
  return $response;
}

// Set the URL for the API
$url = "http://localhost/web11/sarkar/insaaf99/testapp/get_all_lawyer1";

// Fetch the data from the API
$data = getWeather($url);

// Output the data

print_r(json_decode($data,true));

?>