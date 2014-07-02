<?php
 include_once "/var/www/html/pd.oncall.php";
 $oncall = get_person_on_call("PW26FAB"); 

 print $oncall['phone'];


?>
