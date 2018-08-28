<!DOCTYPE html>
<?php
include '../configLibrary.php';
$page->unauthorize();

$email = $username = $password = $checkPassword = "";
$err = array();
$pdo = $page->pdo();
$stm = $pdo->query("SELECT username FROM user");
$usernames = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
$stm = $pdo->query("SELECT email FROM user");
$emails = $stm->fetchALL(PDO::FETCH_COLUMN, 0);
if ($page->is_post()) {
    $email = $page->post('email');
    $username = $page->post('username');
    $password = $page->post('password');
    $checkPassword = $page->post('confirm_password');

    if ($email == "") {
        $err['Email'] = 'Email is empty';
    } else if (strlen($email) > 30) {
        $err['Email'] = 'Email can not more than 30 characters';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err['Email'] = 'Invalid email format';
    } else if (in_array($email, $emails)){
        $err['Email'] = 'Email already exist, try other email';
    }

    if ($username == "") {
        $err['Username'] = 'Username is empty';
    } else if (strlen($username) > 30) {
        $err['Username'] = 'Username can not more than 30 characters';
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $err['Username'] = 'Only letters and numbers allowed';
    } else if (in_array($username, $usernames)){
        $err['Username'] = 'Username already exist, try other username';
    }

    if ($password == "") {
        $err['Password'] = 'Password is empty';
    } else if (strlen($password) > 30) {
        $err['Password'] = 'Password can not more than 30 characters';
    } else if ($checkPassword == "") {
        $err['Password'] = 'Confirm password is empty';
    } else if ($password !== $checkPassword) {
        $err['Confirm_Password'] = 'Password not match';
    }

    if (!$err) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stm = $pdo->prepare("INSERT INTO `customer` (`username`, `password`, `email`, `profile_pic`) VALUES (?,?,?,?)");
        $stm->execute([$username, $password, $email, "profile_picture.jpg"]);
        $ok = $page->email($email, 'Registeration', "
            <div style='text-align: center;'>
                <fieldset>
                    <legend><h1>Area51</h1></legend>
                    <h2>Thanks for register to our website!</h2>
                    <input type='button' hred='http://localhost:8000/index.php'>Lets Begin!</input>
                    <p>We will provide the best service and updated product to serve you better!</p>
                    <p>From Admin</p>
                </fieldset>
            </div>
        ");
        if ($ok) {
            $page->temp('success', 'Password reset. Please check your email.');
            $page->redirect();
        }
        else {
            $err['email'] = 'Failed to send email.';    
        }
    }
}

$page->title = 'Register';
$page->header();
?>
<?= $page->temp('success') ?>
<form method="POST" autocomplete="off">
    <div class="wrapper">
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="form-control" name="email" maxlength="30" value="" placeholder="Enter username" type="text">
            <p><?= $html->err_msg($err, "Email") ?></p>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input id="username" class="form-control" name="username" maxlength="30" value="" placeholder="Enter username" type="text">
            <p><?= $html->err_msg($err, "Username") ?></p>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" class="form-control" name="password" maxlength="30" value="" placeholder="Enter password" type="password">
            <p><?= $html->err_msg($err, "Password") ?></p>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input id="confirm_password" class="form-control" name="confirm_password" maxlength="30" value="" placeholder="Enter password" type="password">
            <p><?= $html->err_msg($err, "Confirm_Password") ?></p>    
        </div>
        <div class="text-center">
            <a href="javascript:history.back()" class="btn btn-secondary button-size">Back</a>
            <button type="submit" class="btn btn-primary button-size">Register</button>
        </div>
    </div>
</form>
<?php
$page->footer();
?>
