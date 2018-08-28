<!DOCTYPE html>
<?php
include '../configLibrary.php';

$email = $username = $password = "";
$err = array();

if ($page->is_post()) {
    $username = $page->post('username');
    $password = $page->post('password');

    if ($username == "") {
        $err['Username'] = 'Username is empty';
    }
    if ($password == "") {
        $err['Password'] = 'Password is empty';
    }

    if (!$err) {
        $pdo = $page->pdo();
        $stm = $pdo->prepare("SELECT * FROM `user` WHERE (`username` = ? OR `email` = ?)");
        $stm->execute([$username, $username]);
        $user = $stm->fetch();

        if ($user && password_verify($password, $user->password)) {
            if ($user->role == 'customer') {
                $stm = $pdo->prepare("SELECT * FROM `customer` WHERE (`username` = ? OR `email` = ?)");
                $stm->execute([$username, $username]);
                $users = $stm->fetch();
                $_SESSION['photo'] = $users->profile_pic;
                $page->sign_in($users->username, $user->role);
                $page->redirect('../index.php');
                var_dump($stm->fetchColumn(0));
            }
        } else {
            $err['Username'] = 'Username or Password invalid';
        }
    }
}
$page->title = 'Login';
$page->header();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <form method="POST" autocomplete="off">
            <div class="wrapper">
                <div class="form-group">
                    <label>Username</label>
                    <input id="username" class="form-control" name="username" type="text" value="" maxlength="30" placeholder="Enter username">
                    <p><?= $html->err_msg($err, "Username") ?></p>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input id="password" class="form-control" name="password" type="password" value="" maxlength="30" placeholder="Enter password">
                    <p><?= $html->err_msg($err, "Password") ?></p>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary login">Login</button><br>
                    <a href="reset_password.php" id="forget_password">Forget password?</a>
                </div>
            </div>
        </form>
    </body>
</html>
<?php
$page->footer();
?>
