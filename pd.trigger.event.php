<?php

function trigger_inc($URL, $trigger_json)
{
  $header_opts = array($type,'Content-Length: ' . strlen($trigger_json));

  if(!function_exists('curl_init'))
  {
     error_log("Curl PHP package not installed\n");
     return "-1";
  }
  $curlHandle = curl_init();

  curl_setopt($curlHandle, CURLOPT_URL, $URL);
  curl_setopt($curlHandle, CURLOPT_HEADER, false);
  curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header_opts);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
  curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $trigger_json);    

  $response = curl_exec($curlHandle);
  $decoded_response= json_decode($response,true);
  return $decoded_response;
}

?>
