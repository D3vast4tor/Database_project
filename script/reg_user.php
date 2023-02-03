
<?php
session_start();
include_once "./db_credentials.php";
$db_conn = new mysqli($host,$user,$password,$db_name);
if($db_conn->connect_error){
    die("Connection failed" . $db_conn->connect_error);
}

/***************************************************************************************************************************************************
 * Prepare statement for optimizing query time since the parsing is done one time(as the preparation of a query) and binded as many time as needed.*
 * It also prevents SQL Injection attacks since the original statement is not delivered from external input like php or a web server in general.   *
 ***************************************************************************************************************************************************/
$user = $db_conn->prepare("insert into User(name,surname,fiscal_code,email) values(?,?,?,?)");
$location = $db_conn->prepare("insert into Location(ID,state,city,cap,street,civic_number) values(?,?,?,?,?,?)");
$pricing = $db_conn->prepare("insert into Pricing(ID,rate_amount,deadline,date) values(?,?,?,?) ");
/************************************************************************************************************************
 * Retriving preaviously collected data, binding parameters to the preaviously parsed statement and executing the query.*
 ************************************************************************************************************************/ 

$name = $_POST['name'];
$surname = $_POST['surname'];
$fiscal_code = $_POST['fiscal_code'];
$email = $_POST['email'];
$user->bind_param("ssss",$name,$surname,$fiscal_code,$email);
$user->execute();
/**********************************************************************************************************************************
 * Retriving the ID assigned by the database, the variable is defined with the AUTO_INCREMENT property to bound the other columns.*
 **********************************************************************************************************************************/ 
$res = $db_conn->query("select ID from User order by ID desc")->fetch_assoc();
$ID = $res['ID'];

$state = $_POST['state'];
$city = $_POST['city'];
$cap = $_POST['cap'];
$street = $_POST['street'];
$civic_number = $_POST['civic_number'];
$location->bind_param("ssssss",$ID,$state,$city,$cap,$street,$civic_number);
$location->execute();

$deadline = strval($_POST["deadline"]);
$rate_amount = "43.82";
$date = date("Ymd");
$date = substr($date,2);
$pricing->bind_param("ssss",$ID,$rate_amount,$deadline,$date );
$pricing->execute();
header("Location: /index.html");
?>