<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/webfont.css">
    </head>

    <body>
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
