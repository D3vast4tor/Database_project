<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./dashboard.css" >
        <?php 
        ?> 
    </head>
    <body>
    <div class='device'></div>

        <?php
        function devices(){
            echo("
            <style>
            div.device{
                opacity: 100%;
                transition:0.05s;
            }
            </style>
            ");
        } 
        include_once "./script/db_credentials.php";
        if(array_key_exists('devices',$_POST)){
            devices();
        }
        session_start();
        $ID = $_SESSION['uid'];
        if($ID == NULL){
            header("Location: https://www.encompower.com/");
        }
        $conn = new mysqli($host,$user,$password,$db_name);
        $stmt = $conn->prepare("select * from Device where ID = ?");
        $stmt->bind_param("s",$_SESSION['uid']);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        
        ?>
        <form method="POST">
            <input type="submit" class="devices" name="devices">
            <input type="submit" class="pay_history" value="History">
        </form>
    </body>
</html>