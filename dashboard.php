<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="dashboard.css" >
        <?php /*
            ini_set('display_errors', 1); 
            ini_set('display_startup_errors', 1); 
            error_reporting(E_ALL);
            */
            
            session_start();
            $ID = $_SESSION['uid'];
            if($ID == NULL){
                header("Location: https://www.encompower.com/");
            }
            session_start();
            $ID = $_SESSION['uid'];
            if($ID == NULL){
                header("Location: https://www.encompower.com/");
            }
            include_once "./script/db_credentials.php";
            $conn = new mysqli($host,$user,$password,$db_name);
            $stmt = $conn->prepare("select * from Device where user_id = ?");
            $stmt->bind_param("s",$_SESSION['uid']);
            $stmt->execute();
            $res = $stmt->get_result();
            /************************************************************
             * The $res variable is considered as both a dictionary     *
             * and a matrix so we can access each row with the standard *
             * index notation but also single value in columns          *
             * with the corresponding key, meaning the actual           *
             * name of the sql column mariadb has.                      *
             ************************************************************/
            ?>
    </head>
    <body>
        <div class="device">
            <form method="POST">
                <input type="submit" class="close" name="close" value="">
            </form>
            <ul>
                <?php
                    function devices(){
                        echo "<style>div.device{opacity: 100%;}</style>";
                    } 
                    function close_device(){
                        echo "<style>div.device{opacity: 0;}</style>";
                    }
            
                    if(array_key_exists('devices',$_POST)){
                        devices();
                    }
                    if(array_key_exists('close',$_POST)){
                        close_device();
                    }
                    if($res->num_rows > 0){
                        while($row = $res->fetch_assoc()){
                            echo "<li><div class='dev_det'><img class='" . $row["type"] . "' src='/img/" . $row["type"] . ".png'><p>" . $row['type'] . "</p></div></li>";
                        }
                    }else{
                        /* SOMEHOW ECHO SOME HTML SNIPPETS AND MAKE IT PREATTY WITH CSS DUMBASS.*/
                    }
                ?>
            </ul>
        </div>
        <form method="POST">
            <input type="submit" class="devices" name="devices" value="">
            <input type="submit" class="pay_history" value="History">
        </form>
    </body>
</html>