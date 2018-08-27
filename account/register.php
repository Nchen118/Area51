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

    if ($email == "") {
        $err['Email'] = 'Email is empty';
    } else if (strlen($email) > 30) {
        $err['Email'] = 'Email can not more than 30 characters';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err['Email'] = 'Invalid email format';
    }

    if ($username == "") {
        $err['Username'] = 'Username is empty';
    } else if (strlen($username) > 30) {
        $err['Username'] = 'Username can not more than 30 characters';
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $err['Username'] = 'Only letters and numbers allowed';
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
        $pdo = $page->pdo();
        $stm = $pdo->prepare("INSERT INTO `customer` (`username`, `password`, `email`, `profile_pic`) VALUES (?,?,?)");
        $stm->execute([$username, $password, $email, "profile_picture.jpg"]);
        echo 'Success';
    }
}
$page->title = 'Register';
$page->header();
?>
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
        <button type="reset" class="btn">Reset</button>
        <button type="submit" class="btn">Register</button>
    </div>
</form>
<?php
$page->footer();
?>
