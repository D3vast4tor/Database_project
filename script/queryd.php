<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once "/Database_project/src/vendor/autoload.php";
use Spatie\Async\Pool;
$pool = Pool::create();
include "/Database_project/script/db_credentials.php";
$conn = new mysqli($host,$user,$password,$db_name);
$res = $conn->query("SELECT * FROM Pricing");
while(1){
    $pool->add(function () use ($res){
        while($row = $res->fetch_assoc()){
            $count = 1;
            $ID = $row['id'];
            $date =  str_replace("-","",$row['date']);
            if((("20".date("ymd"))-$date)<= 0){
                $count += 1;
                echo $count;
            }
        }
    });
}
?>