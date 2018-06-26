<!DOCTYPE html>
<html>
    <body>
        <style>
            body {font-family: Arial, Helvetica, sans-serif;}
            * {box-sizing: border-box}
            input[type=text], input[type=password] {
                width: 50%;
                padding: 15px;
                margin: 5px 0 22px 0;
                display: inline-block;
                border: none;
                background: #f1f1f1;
            }
            button {
                background-color: #4CAF50;
                color: white;
                padding: 10px 10px;
                margin: 8px 0;
                cursor: pointer;
                width: 200;
            }
            button:hover {
                opacity: 1;
            }

        </style>

        <h1>REGISTER</h1>

        <p>Please fill in this form to create an account.</p>
        <form class="login">
            <hr>
            <label for="email"><p><b>Email</b><p></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <p><label for="psw"><p><b>Password</b></p></label>
                <input type="password" placeholder="Enter Password" name="psw" required></p>

            <p><label for="psw-repeat"><p><b>Repeat Password</b></p></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" required></p>

            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
                <P><button type="submit" class="signupbtn">Sign Up</button></P>
                <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
            </label>
            <span class="login">Already have an account? <a href="login.php">LOGIN HERE</a></span>


        </form>

    </body>

</html>
