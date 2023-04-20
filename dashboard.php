<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <style>
            body{
               background-image: url("/img/dashboard_back.jpg"); 
               background-position: center;
               background-repeat: no-repeat;
            }
        </style>
        <script>
            function device(){
                var elem = document.getElementById("devices");
                if(elem.style.opacity == 0){
                    elem.style.opacity=100;
                }else{
                    elem.style.opacity=0;
                }
            }
        </script>
        <?php /*
            ini_set('display_errors', 1); 
            ini_set('display_startup_errors', 1); 
            error_reporting(E_ALL);
            */
            
            session_start();
            $ID = $_SESSION['uid'];
            if($ID == NULL){
                header("Location: index.html");
            }
            include_once "./script/db_credentials.php";
            $conn = new mysqli($host,$user,$password,$db_name);
            $stmt = $conn->prepare("select * from User where ID = ?");
            $stmt->bind_param("s",$ID);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();
            /************************************************************
             * The $res variable is considered as both a dictionary     *
             * and a matrix so we can access each row with the standard *
             * index notation but also single value in columns          *
             * with the corresponding key, meaning the actual           *
             * name of the sql column mariadb has.                      *
             ************************************************************/
            $stmt = $conn->prepare("select * from Device where user_id=?");
            $stmt->bind_param("s",$ID);
            $stmt->execute();
            $devices = $stmt->get_result();
            ?>
    </head>
    <body>
        <nav class="navbar bg-dark">
            <div class="container">
                <div class="row">
                    <a class="navbar-brand text-white ms-2 fs-2 text-decoration-none font-monospace fw-bold"><img class="me-5" src="/img/user.png" width="auto" height="100">Welcome <?php echo $res['name']?></a>
                </div>
                <div class="row"><button class=" btn btn-lg btn-secondary bg-gradient me-5 " type="button" onclick="device()">Device</button></div>
                <div class="row"><button class="btn btn-lg btn-secondary bg-gradient me-5 " type="button" onclick="pricing()">Pricing</button></div>
                <div class="row"><button class="btn btn-lg btn-secondary bg-gradient me-5 " type="button" data-bs-toggle="modal" data-bs-target="#account">Account</button></div>
            </div>
        </nav>
            <div class="container-md bg-dark bg-gradient rounded mt-5 border border-white border-5" id="devices" style="opacity: 0;">
                <?php 
                    echo "
                    <div class='row align-self-center'>
                        <p class='text-center text-white fs-1 font-weight-bold mt-3'>Devices you own</p>
                    </div>
                    <div class='row row-cols-auto' style='justify-content:space-evenly;'>";
                    while($row = $devices->fetch_assoc()){
                        $device = $row['type'];
                        echo "
                            <div class='col'>
                                <div class='card bg-transparent' style='width:12rem;border:0;'>
                                    <img src='/img/$device.png'>
                                    <div class='card-body'>
                                        <h4 class='card-title text-center text-white fs-3'>$device</h4>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                    echo "</div>";
                ?>
                <div class="d-flex bg-dark bg-gradient rounded border border-white border-5 mt-5">
                    <ul class="list-groups">

                    </ul>
                </div>
            </div>
    </body>
</html>