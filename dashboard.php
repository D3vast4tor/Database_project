<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1"/>
        <link href="/css/palette.css" rel="stylesheet" type="text/css">
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
                var elem2 = document.getElementById("pricing");
                if(elem.style.opacity == 0){
                    elem.style.opacity=100;
                }else{
                    elem.style.opacity=0;
                }
                if(elem2.style.opacity == 100){
                    elem2.style.opacity = 0;
                }
            }
            function pricing(){
                var elem = document.getElementById("pricing");
                var elem2 = document.getElementById("devices");
                if(elem.style.opacity == 0){
                    elem.style.opacity = 100;
                }else{
                    elem.style.opacity = 0;
                }
                if(elem2.style.opacity == 100){
                    elem2.style.opacity = 0;
                }
            }
            function show_modal(){
                let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('account'))
                modal.show();
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
            $device = $conn->query("Select * from Device where user_id=$ID");
            $pricing = $conn->query("Select * from Pricing where id=$ID order by id_bill asc");
            $location = $conn->query("Select * from Location where ID=$ID")->fetch_assoc();
            ?>
    </head>
    <body>
        <nav class="navbar bg-dark">
            <div class="container">
                <div class="row">
                    <a class="navbar-brand text-white ms-2 fs-2 text-decoration-none font-monospace fw-bold"><img class="me-5" src="/img/user.png" width="auto" height="100">Welcome <?php echo $res['name']?></a>
                </div>
                <div class="row"><button class=" btn btn-lg bg-indigo-indigo-600 bg-gradient me-5 " type="button" onclick="device()">Device</button></div>
                <div class="row"><button class="btn btn-lg bg-indigo-indigo-600 bg-gradient me-5 " type="button" onclick="pricing()">Pricing</button></div>
                <div class="row"><button class="btn btn-lg bg-indigo-indigo-600 bg-gradient me-5 " type="button" data-toggle="modal" data-target="#account" onclick="show_modal()">Account</button></div>
            </div>
        </nav>
        <div class="container-md bg-dark bg-gradient rounded mt-5 border border-white border-5 overflow-auto" id="devices" style="opacity: 0;">
            <?php 
                echo "
                <div class='row align-self-center'>
                    <p class='text-center text-white fs-1 font-weight-bold mt-3'>Devices you own</p>
                </div>
                <div class='row row-cols-auto' style='justify-content:space-evenly;'>";
                while($row = $device->fetch_assoc()){
                    $dev = $row['type'];
                    echo "
                        <div class='col'>
                            <div class='card bg-transparent' style='width:12rem;border:0;'>
                                <img src='/img/$dev.png'>
                                <div class='card-body'>
                                    <h4 class='card-title text-center text-white fs-3'>$dev</h4>
                                </div>
                            </div>
                        </div>
                    ";
                }
                echo "</div>";
            ?>
        </div>
        <div class="container-sm rounded justify-content-center mb-5 overflow-auto" id="pricing" style="opacity: 0;">
            <div class="row row-cols-5 bg-primary bg-gradient">
            <div class="col fw-bold fs-3 text-center border border-dark">Bill ID</div>
                <div class="col fw-bold fs-3 text-center border border-dark">Issuing</div>
                <div class="col fw-bold fs-3 text-center border border-dark ">Amount</div>
                <div class="col fw-bold fs-3 text-center border border-dark ">Deadline</div>
                <div class="col fw-bold fs-3 text-center border border-dark ">Paid</div>
            </div>
            <?php 
                while($row = $pricing->fetch_assoc()){
                    echo "
                        <div class='row row-cols-5 bg-secondary bg-gradient '>
                            <div class='col fs-3 text-center border border-dark'>".$row['id_bill']."</div>
                            <div class='col fs-3 text-center border border-dark'>".$row['date']."</div>
                            <div class='col fs-3 text-center border border-dark'>".$row['rate_amount']."</div>
                            <div class='col fs-3 text-center border border-dark'>".$row['deadline']."</div>
                            <div class='col fs-3 text-center border border-dark'>";if(!$row['paid']){echo "Paid";}else{echo "Not Paid";} echo "</div>
                        </div>
                    ";
                }
            ?>
            </div>       
            <div class="modal fade" tabindex="-1" role="dialog" id="account">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content bg-transparent">
                        <div class="modal-header justify-content-center bg-indigo-indigo-600 bg-gradient border border-dark rounded">
                            <p class="fw-bold fs-2 text-center">Personal Data</p>
                        </div>
                        <div class="modal-body bg-blue-blue-200 bg-gradient rounded">
                        <div class="row row-cols-auto justify-content-around">
                            <div class="col"><label for="name" class="form-control-label fs-4">Nome:</label></div>
                            <div class="col"><input id="name" class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" type="text" readonly value='<?php echo $res['name']; ?>'></div>
                            <div class="col"><label for="surname" class="form-control-label fs-4">Cognome:</label></div>
                            <div class="col"><input id="surname" class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" type="text" readonly value='<?php echo $res['surname'];?>'></div>
                        </div>
                        <div class="row row-cols-auto justify-content-around mt-3 ps-1">
                            <div class="col"><label for="email" class="form-control-label fs-4">Email: </label></div>
                            <div class="col"><input id="email" type="text" readonly class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" value='<?php echo $res['email']; ?>'></div>
                            <div class="col"><label for="password" class="form-control-label fs-4">Password:</label></div>
                            <div class="col"><input id="password" type="password" readonly class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" value='<?php echo $res['password']; ?>'></div>
                        </div>
                        </div>
                        <div class="modal-header justify-content-center bg-indigo-indigo-600 bg-gradient border border-dark rounded">
                            <p class="fw-bold fs-2 text-center">Location Info</p>
                        </div>
                        <div class="modal-body bg-blue-blue-200 bg-gradient rounded">
                            <div class="row row-cols-auto justify-content-around">
                                <div class="col"><label for="state" class="form-control-label fs-4">Stato:</label></div>
                                <div class="col"><input id="state" class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" type="text" readonly value='<?php echo $location['state']; ?>'></div>
                                <div class="col"><label for="city" class="form-control-label fs-4">Città:</label></div>
                                <div class="col"><input id="city" class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" type="text" readonly value='<?php echo $location['city'];?>'></div>
                                <div class="col"><label for="street" class="form-control-label fs-4">Via:</label></div>
                                <div class="col"><input id="street" class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" type="text" readonly value='<?php echo $location['street']; ?>'></div>
                            </div>
                            <div class="row row-cols-auto justify-content-evenly mt-3 ps-1">
                                <div class="col"><label for="civic_number" class="form-control-label fs-4">Numero Civico:</label></div>
                                <div class="col"><input id="civic_number" class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" type="number" readonly value='<?php echo $location['civic_number'];?>'></div>
                                <div class="col"><label for="CAP" class="form-control-label fs-4">CAP:</label></div>
                                <div class="col"><input id="CAP" class="form-control fw-bold text-dark border border-dark bg-secondary bg-gradient" type="number" readonly value='<?php echo $location['cap'] ?>'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>