<?php 
session_start();
session_save_path("/cert");
include_once "./db_credentials.php";
$conn = new mysqli($host,$user,$password,$db_name);
if($conn->connect_error){
    header("Location: /login.html");
}
$email = $_POST['email'];
$pass = $_POST['password'];

$stmt = $conn->prepare("select * from User where email = ?");
$stmt->bind_param("s",$email);
$sel = $stmt->execute($res);
$res = $stmt->get_result()->fetch_assoc();
if(!$res){
    /*************************
     *  HANDLER OF BAD LOGIN * 
     *   WORK IN PROGRESS    *
     *************************/
}
$serv_email = $res['email'];
$serv_password = $res['password'];
if(strcmp($email,$serv_email) != 0){
    /*************************
     *  HANDLER OF BAD LOGIN * 
     *   WORK IN PROGRESS    *
     *************************/
}
if(strcmp($pass,$serv_password) != 0){
    /*************************
     *  HANDLER OF BAD LOGIN * 
     *   WORK IN PROGRESS    *
     *************************/
}
$_SESSION['uid'] = $res['ID'];
$session_id = session_id();
header("Location: /dashboard.php?" . SID);
?>