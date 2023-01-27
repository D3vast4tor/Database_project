
<?php
ini_set('display_errors', 1);
$host = "www.encompower.com";
$user = "root";
$password = "!.D3vast4tor.!";
$db_name = "EnCom";
$db_conn = new mysqli($host,$user,$password,$db_name);
if($db_conn->connect_error){
    die("Connection failed" . $db_conn->connect_error);
}

$user = $db_conn->prepare("insert into User(name,surname,fiscal_code,email) values(?,?,?,?)");
$location = $db_conn->prepare("insert into Location(ID,state,city,cap,street,civic_number) values(?,?,?,?,?,?)");
$pricing = $db_conn->prepare("insert into Pricing(ID,rate_amount,deadline,date) values(?,?,?,?) ");

$name = $_GET['name'];
$surname = $_GET['surname'];
$fiscal_code = $_GET['fiscal_code'];
$email = $_GET['email'];
$user->bind_param("ssss",$name,$surname,$fiscal_code,$email);
$ID = $db_conn->query("select ID from User order by ID desc limit 1;");
$state = $_GET['state'];
$city = $_GET['city'];
$cap = $_GET['cap'];
$street = $_GET['street'];
$civic_number = $_GET['civic_number'];
$location->bind_param("ssssss",$ID,$state,$city,$cap,$street,$civic_number);

$deadline = $_GET['deadline'];
$rate_amount = "43.82";
$date = date("Ymd");
$date = substr($date,2);
$pricing->bind_param("isdi",$ID,$rate_amount,$deadline,$date );

$user->execute();
$location->execute();
$pricing->execute();
echo "all done.";
?>