<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://www.encompower.com/rlbackground.css">
    </head>
    <body>
        <div class="register">
            
        </div>
        <div class="reg">
        <form action="./db.php" method="GET">
                <h2>Registration form</h2>
                <input type="text" name="name" placeholder="Name" class="name">
                <input type="text" name="surname" placeholder="Surname" class="surname">
                <input type="text" name="fiscal_code" placeholder="Fiscal Code" class="fiscal_code">
                <input type="text" name="email" placeholder="Enter an email address to be contacted." class="email">
                <h3>Location</h3>
                <input type="text" name="state" placeholder="State" class="state">
                <input type="text" name="city" placeholder="City" class="city">
                <input type="text" name="cap" placeholder="CAP" class="cap">
                <input type="text" name="street" placeholder="Street" class="street">
                <input type="number" name="civic_number" placeholder="N°" class="civic_number">   
                <h3>Contract Terms</h3>           
                <select class="deadline" name="deadline">
                    <option value="monthly">Monthly</option>
                    <option value="bimonthly">Bimonthly</option>
                    <option value="quartely">Quartely</option>
                </select>
                <br>
                <input type="checkbox" value="eula" id="eula" class="eula">
                <label for="eula" class="terms">By clicking here you accept to be contacted via email you've just send us.<br></label>
                <input type="submit" value="Send Contract Request">
            </form>
        </div>
    </body>
</html>