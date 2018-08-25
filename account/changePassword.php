<?php
include '../configLibrary.php';
$page->authorize();

$password = $new = $confirm = '';
$err = [];

if ($page->is_post()) {
    $password = $page->post('password');
    $new      = $page->post('new');
    $confirm  = $page->post('confirm');
    
    if ($password == '') {
        $err['password'] = 'Password is required.';
    }
    
    if ($new == '') {
        $err['new'] = 'New Password is required.';
    }
    else if (strlen($new) < 5) {
        $err['new'] = 'New Password must more than 5 characters.';
    }
    else if (!preg_match('/^\S+$/', $new)) {
        $err['new'] = 'New Password should not contain spaces.';
    }

    if ($confirm == '') {
        $err['confirm'] = 'Confirm Password is required.';
    }
    else if ($confirm != $new) {
        $err['confirm'] = 'Confirm Password and New Password not matched.';
    }
    
    if (!$err) {
        $pdo = $page->pdo();
        $stm = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stm->execute([$page->user->name]);
        $user = $stm->fetch();
        
        if ($user != null && password_verify($password, $user->password)) {       
            $table = $user->role;
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $stm = $pdo->prepare("UPDATE $table SET password = ? WHERE username = ?");
            $stm->execute([$hash, $page->user->name]);
            
            $page->temp('success', 'Password changed.');
            //<todo>
            $page->redirect();
        }
        else {
            $err['password'] = 'Password not matched.';
        }
    }
}

$page->title = 'Change Password';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<form method="post">
    <div class="form">
        <div>
            <label for="password">Password</label>
            <?php $html->password('password', $password) ?>
            <?php $html->err_msg($err, 'password') ?>
        </div>
        <div>
            <label for="new">New Password</label>
            <?php $html->password('new', $new) ?>
            <?php $html->err_msg($err, 'new') ?>
        </div>
        <div>
            <label for="confirm">Confirm Password</label>
            <?php $html->password('confirm', $confirm) ?>
            <?php $html->err_msg($err, 'confirm') ?>
        </div>
    </div>
    
    <button>Change Password</button>
    <button type="reset">Reset</button>
</form>

<?php
$html->focus('password', $err);
$page->footer();
?>
