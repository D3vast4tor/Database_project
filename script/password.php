<!DOCTYPE html>
<html lang="en">
<head>

    <title>Registration Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            var btn = document.getElementById("check");
            var element = document.getElementById("pass_err");

            // Create toast instance
            var myToast = new bootstrap.Toast(element);
            btn.addEventListener("click", function(){
            var pass = document.getElementById("password").value;
            var conf_pass = document.getElementById("conf_pass").value;
                if(!(pass == conf_pass)){
                    myToast.show();
                }else{
                    document.cookie = "password="+pass;
                    document.cookie = "SameSite=None";
                    console.log(document.cookie);
                }
            });
        });
    </script>
</head>
<body class="bg-black bg-gradient" style="background-repeat: no-repeat;">
    <div class="d-flex justify-content-center mt-5 pt-5">
        <form class="form-control-lg bg-transparent bg-gradient mt-5 needs-validation" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="row">
                <p class="text-white text-wrap text-center fs-3">Create Password</p>
            </div>
            <div class="row">
                <div class="col has-validation">
                    <input class="form-control" type="password" name="password" placeholder="Password" id="password" required>
                </div>
            </div>
            <div class="row">
                <div class="col has-validation pt-3">
                    <input class="form-control" type="password" name="conf_password" placeholder="Confirm Password" id="conf_pass" required>
                </div>
            </div>
            <div class="row">
                <div class="col pt-4 ms-4">
                    <input type="button"  id="check" class="btn btn-lg btn-secondary btn-gradient d-flex justify-content-center" value="Set Password">
                </div>
            </div>
        </form>
    </div>
    <div class='toast position-absolute start-50 top-50 translate-middle bg-danger bg-gradient' role='alert' aria-live='assertive' aria-atomic='true' id="pass_err">
        <div class='toast-header'> 
            <strong class='me-auto'>Error Setting Password</strong>
            <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
        </div>
        <div class='toast-body'>
            Make sure the password matches, if this persist contact support.
        </div>
    </div>
    <?php 
        ini_set('display_errors', 1); 
        ini_set('display_startup_errors', 1); 
        error_reporting(E_ALL);
        if(isset($_COOKIE['password'])){
            session_start();
            $ID = $_SESSION['ID'];
            $pass = $_COOKIE['password'];
            include_once "/Database_project/script/db_credentials.php";
            $conn = new mysqli($host,$user,$password,$db_name);
            $conn->query("Update User set password='$pass' where ID=$ID");
            header("Location: /dashboard.php?" . SID);
        }
    ?>
</body>
</html>


