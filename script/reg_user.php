
<?php
ini_set('display_errors',1);
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../src/vendor/autoload.php';

include_once "./db_credentials.php";

$mail = new PHPMailer(true);

$db_conn = new mysqli($host,$user,$password,$db_name);
if($db_conn->connect_error){
    die("Connection failed " . $db_conn->connect_error);
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
header("Location: https://".$_SERVER["HTTP_HOST"]."/index.html");
$_SESSION['ID'] = $ID;
$url = "https://".$_SERVER['HTTP_HOST']."/script/password.php?". SID;
try{/***************************************************************
     * SET REQUIRED PARAMETER LIKE SMARTHOST RELAY, SMARTHOST PORT *
     * AND THE CREDENTIAL REQUIRED FOR SMTPS AUTHENTICATION        *
     ***************************************************************/
     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
     $mail->isSMTP();
     $mail->Host = 'smtp-relay.sendinblue.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'mattiar.o@live.it';
     $mail->Password = 'Dcgr4SX78WNRjHGL';
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port = 587;
 
     $mail->setFrom("registration@encompower.com");
     $mail->addAddress($email);
 
     $mail->isHTML(true);
     $mail->Subject = "Test mail for registration purpose";
     $mail->Body = "<!DOCTYPE html>
     <html lang='en'>
     <head>
         <meta name='viewport' content='width=device-width, initial-scale=1'>
         <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
         <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
         <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js' integrity='sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB' crossorigin='anonymous'></script>
         <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js' integrity='sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13' crossorigin='anonymous'></script>
     </head>
     <body class='bg-dark bg-gradient' style='background-repeat: no-repeat;'>
         <div class='d-flex justify-content-center '>
             <h1 class='text-white mt-3'>Confirm Registration to <span class='badge rounded-pill bg-secondary bg-gradient'>EnCom</span></h1>
         </div>
         <p class='text-white text-wrap text-center fs-5'>You have received this email after our systems received a registration request providing this email.</p>
         <p class='text-white text-wrap text-center fs-5'>If you didn't want to register simply ignore this message.</p>
         <p class='text-white text-wrap text-center fs-5'>Otherwise just click on the link below to complete the registration process.</p>
         <div class='d-flex justify-content-center'><span class='btn btn-lg btn-success btn-gradient'><a href='$url' class='text-decoration-none text-black'>Confirm Registration</a></span></div>
         <p class='text-white text-wrap text-center fs-5'>Thank you for registering at our company. We hope our services will satisfy you. For any problem contact the support at support@encompower.com</p>
     </body>
     </html>";
 
     $mail->send();
 } catch (Exception $e){
     echo "Mail not send. Mailer Error: {$mail->ErrorInfo}";
     /* Error sending email */
 }
?>