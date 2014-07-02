<?php
 
    if($_REQUEST['Digits'] != '1' and $_REQUEST['Digits'] != '2') {
        header("Location: greeting.php");
        die;
    }
     
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    session_start();
?>
<Response>
<?php error_log($_SESSION['on_call_phone'] . "\n",3,"/tmp/php_error_key.log"); ?>

<?php if ($_REQUEST['Digits'] == '1') { ?>
    <Dial><?php print "+1" . $_SESSION['on_call_phone']; ?> </Dial>
    <Say>The call failed or the remote party hung up.  Goodbye.</Say>
<?php } elseif ($_REQUEST['Digits'] == '2') { ?>
    <Say>Recording a message will open a standard 
         incident and it will be paged out.
         Record your message after the tone. 
         When you have finished recording, press #</Say>
    <Record maxLength="5" action="handle-recording.php" />
<?php } ?>
</Response>
