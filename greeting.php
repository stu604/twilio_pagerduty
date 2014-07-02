<?php
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    // if this is the top line, the call wont be answered...
    include_once "/var/www/html/pd.oncall.php";
    session_start();
?>
<Response>
    <Say>,Hello, Welcome to Vivonet's  Support Service .</Say>
    <?php $oncall = get_person_on_call();
          $_SESSION['on_call_name'] = $oncall['name'];
          $_SESSION['on_call_phone'] = $oncall['phone'];
     ?>
 
    <Say> <?php print $oncall['name']; ?> is currently on call. </Say> 
    <Gather numDigits="1" action="greeting-key-press.php" method="POST">
        <Say>
            To speak with, <?php print $oncall['name']; ?>, press 1.  
            Press 2 to record a message.  
            Press any other key to start over.
        </Say>
    </Gather>
</Response>

