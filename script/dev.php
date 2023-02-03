<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php 
            ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
            include_once "/Database_project/script/db_credentials.php";
            $c = new mysqli($host,$user,$password,$db_name);
            $stmt = "SELECT * FROM Device where user_id = ?";
            $stmt = $c->prepare($stmt);
            $user_id = 1;
            $stmt->bind_param("i",$user_id);
            $stmt->execute();
            $stmt = $stmt->get_result();
            $stmt = $stmt->fetch_all(MYSQLI_BOTH);
            echo($stmt[0]['device_id']);
            echo($stmt[1]['device_id']);
        ?>
    </body>
</html>
