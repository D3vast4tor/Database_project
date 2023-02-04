<?php 
ini_set('display_errors',1);
$from = "d3vast4tor@encom.com";
$to = "mattiar.o@live.it";
$subject = "Test mail";
$message = "Suca";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Test email sent";
?>