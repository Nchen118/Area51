<!DOCTYPE html>
<html>
    <style>
    body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}
input[type=text], input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}
span.psw {
    float: right;
    padding-top: 16px;
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
    <body>
        <h2>LOGIN</h2>
        
        <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
       
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
        <button type="submit">Login</button>
        <span class="psw"><a href="fpassword">Forgot password?</a></span>
        <span class="register"><br>Do not have account?</br><a href="register">Register Here!!</a></span>
        
        
    </body>
</html>
