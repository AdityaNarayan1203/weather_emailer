<?php
function getWeather($url)
{
   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HEADER, false);

   $response = curl_exec($ch);

   // Check for cURL errors
   if (curl_errno($ch)) {
      echo 'cURL error: ' . curl_error($ch);
      return null; // Return null if there's an error
   }

   curl_close($ch);

   // Decode JSON response
   $decodedResponse = json_decode($response, true);
   return $decodedResponse;
}
