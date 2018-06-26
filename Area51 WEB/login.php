<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/adjustment.css"/>
        <link rel="stylesheet" href="css/webfont.css">
    </head>
    <body>
        <form method="post">
            <h2>LOGIN</h2>

            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname">

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw">

            <label><input type="checkbox" checked="checked" name="remember">Remember me</label>
            <input type="submit" value="Login">
            <span class="psw"><a href="fpassword">Forgot password?</a></span>
            <span class="register"><br>Do not have account?</br><a href="register.php">Register Here!!</a></span>
        </form>
    </body>
</html>
