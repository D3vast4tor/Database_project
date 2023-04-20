<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php 
            ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
            include "/Database_project/script/db_credentials.php";
            require "/Database_project/src/vendor/autoload.php";
            $loop = Amp\ReactAdapter\ReactAdapter::get();
            $conn = new mysqli($host,$user,$password,$db_name);
            $row = $conn->query("SELECT * FROM Pricing")->fetch_assoc();
            
        ?>
    </body>
</html>
