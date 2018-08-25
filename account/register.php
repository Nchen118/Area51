<!DOCTYPE html>
<?php
include '../configLibrary.php';

$email = $username = $password = $checkPassword = "";
$err = array();

if ($page->is_post()) {
    $email = $page->post('email');
    $username = $page->post('username');
    $password = $page->post('password');
    $checkPassword = $page->post('confirm_password');

    if ($email == ""){
        $err['Email'] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err['Email'] = 'Invalid email format';
    }
    
    if ($username == "") {
        $err['Username'] = 'Username is empty';
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $err['Username'] = 'Only letters and numbers allowed';
    }
    
    if ($password == "") {
        $err['Password'] = 'Password is empty';
    } else if ($checkPassword == "") {
        $err['Password'] = 'Confirm password is empty';
    } else if ($password !== $checkPassword) {
        $err['Confirm_Password'] = 'Password not match';
    }
    
    if(!$err){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $pdo = $page->pdo();
        $stm = $pdo->prepare("INSERT INTO `customer` (`username`, `password`, `email`) VALUES (?,?,?)");
        $stm->execute([$username, $password, $email]);
        echo 'Success';
    }
}
$page->title = 'Register';
$page->header();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <link type="text/javascript" href="js/jquery-3.3.1.min.js">
        <link rel="stylesheet" type="text/css" href="css/sites.css">
    </head>
    <body>
        <form method="POST">
            <label><p>Email <input id="email" name="email" maxlength="30" value="" placeholder="Enter username" type="text"> <?= $html->err_msg($err, "Email") ?></p></label>
            <label><p>Username <input id="username" name="username" maxlength="30" value="" placeholder="Enter username" type="text"> <?= $html->err_msg($err, "Username") ?></p></label>
            <label><p>Password <input id="password" name="password" maxlength="30" value="" placeholder="Enter password" type="password"> <?= $html->err_msg($err, "Password") ?></p></label>
            <label><p>Confirm Password <input id="confirm_password" name="confirm_password" maxlength="30" value="" placeholder="Enter password" type="password"> <?= $html->err_msg($err, "Confirm_Password") ?></p></label>      
            <button type="reset">Reset</button>
            <button type="submit">Register</button>
        </form> 
    </body>
</html>
<?php
$page->footer();
?>
