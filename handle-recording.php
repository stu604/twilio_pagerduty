<?php
  header("content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
  include_once "/var/www/html/goo.gl.php";
  include_once "/var/www/html/pd.trigger.event.php";
  include_once "/var/www/html/pd.api.key.php";
  $auth_key = pd_api_trigger_key();
  $short_url = goo_gl_url($_REQUEST['RecordingUrl']. ".mp3");
  $trigger_url = "https://events.pagerduty.com/generic/2010-04-15/create_event.json";

  $incdent_array = array(service_key  => $auth_key,
                       event_type   => 'trigger',
                       description  => 'Inbound Call / Voicemail',
                       details      => array (call_back => 'fixme', Voicemail => $short_url)
                       );
  $trigger_json = json_encode($incdent_array);

  $response = trigger_inc($trigger_url,$trigger_json);

?>

<Response>
    <Say>Message Recorded..</Say>
    <Say>Goodbye.</Say>
</Response>

