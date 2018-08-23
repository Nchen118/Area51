<!DOCTYPE html>
<?php
include 'configLibrary.php';

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
    
    if(!$err){
        $pdo = $page->pdo();
        $stm = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stm->execute([$username]);
        $user = $stm->fetch();
        
        if($user && password_verify($password, $user->password)){
            if($user->role == 'customer'){
                $stm = $pdo->prepare("SELECT profile_pic FROM customer WHERE username = ?");
                $stm->execute([$username]);
                $_SESSION['profile_pic'] = $stm->fetchColumn();
                $page->redirect('index.php');
            }
        }
        else {
            $err['Password'] = 'Username or Password invalid';
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
        <form method="POST">
            <label><p>Username <input id="username" name="username" type="text" value="" maxlength="30" placeholder="Enter username"> <?= $page->err_msg($err, "Username") ?></p></label>
            <label><p>Password <input id="password" name="password" type="password" value="" maxlength="30" placeholder="Enter password"> <?= $page->err_msg($err, "Password") ?></p></label>
            <button type="submit">Login</button>
        </form>
    </body>
</html>
<?php
$page->footer();
?>
