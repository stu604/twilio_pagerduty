<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

function req_short_url($url, $type, $content)
{
  if(!function_exists('curl_init'))
  {
     error_log("Curl PHP package not installed\n");
     return "-1";
  }

  $curlHandle = curl_init();

  curl_setopt($curlHandle, CURLOPT_URL, $url);
  curl_setopt($curlHandle, CURLOPT_HEADER, false);
  curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($type));
  curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $content);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

  $response = curl_exec($curlHandle);

  return $response;
}

function goo_gl_url ($long_url)
{
  $url = "https://www.googleapis.com/urlshortener/v1/url";
  $content_type = "Content-Type: application/json";
  $request_type = "longUrl";
  $api_key='XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

  $request = array($request_type => $long_url);
  $jsonrequest = json_encode($request);
  $response = req_short_url($url."?key=$api_key", $content_type, $jsonrequest);
  $short_url = "";

  if (isset($response))
  {
     $dresponse = json_decode($response);
     if (json_last_error() == JSON_ERROR_NONE)
     {
        if (isset($dresponse->{'id'}))
        {
           $short_url = $dresponse->{'id'};
        }
     }
  }
  else
  {
    return "-1";
  }

  return $short_url;
}

?>
