<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
include_once "/var/www/html/pd.api.key.php";


function get_json_request($URL, $type, $auth_key) 
{
  $header_opts = array($type,"Authorization: Token token=$auth_key");

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
  $response = curl_exec($curlHandle);
  $decoded_response= json_decode($response,true);
  return $decoded_response; 
}

function get_person_on_call($schedule_id)
{
  $auth_key = pd_api_key_rw(); 

  $base_url="https://vivonet.pagerduty.com/api/v1/";
  $time_begin = time();
  $time_end = time() + 60;

  date_default_timezone_set("Canada/Pacific");

  $since= date(DATE_ISO8601, $time_begin);
  $until = date(DATE_ISO8601, $time_end);

  $url = "$base_url/schedules/PW26FAB/users?since=$since&until=$until";
  $content_type = "Content-Type: application/json";

  $on_call_json = get_json_request($url,$content_type,$auth_key);
  $on_call_id = $on_call_json['users'][0]['id'];

  $on_call_name = $on_call_json['users'][0]['name'];  

  $url = "$base_url/users/$on_call_id/contact_methods";
  $on_call_json = get_json_request($url,$content_type,$auth_key);

  $on_call_phone = ""; 
  foreach ($on_call_json['contact_methods'] as $method)
  {
    if (isset($method['type']) && 
        $method['type'] == 'phone' &&
        $method['label'] == 'Mobile')
    {
      $on_call_phone =  $method['phone_number']; 
    }  
  }
  $on_call = array (id => $on_call_id, name => $on_call_name, phone => $on_call_phone);
  return $on_call;
}

?>

