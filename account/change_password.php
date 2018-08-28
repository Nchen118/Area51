<?php
include '../configLibrary.php';
$page->authorize();

$password = $new = $confirm = '';
$err = [];

if ($page->is_post()) {
    $password = $page->post('password');
    $new = $page->post('new');
    $confirm = $page->post('confirm');

    if ($password == '') {
        $err['password'] = 'Password is required.';
    }

    if ($new == '') {
        $err['new'] = 'New Password is required.';
    } else if (strlen($new) < 6) {
        $err['new'] = 'New Password must more than 6 characters.';
    } else if (!preg_match('/^\S+$/', $new)) {
        $err['new'] = 'New Password should not contain spaces.';
    }

    if ($confirm == '') {
        $err['confirm'] = 'Confirm Password is required.';
    } else if ($confirm != $new) {
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
        } else {
            $err['password'] = 'Password not matched.';
        }
    }
}

$page->title = 'Change Password';
$page->header();
?>

<?= $page->temp('success') ?>
<fieldset class="border border-light">
<legend><h2 class="text-center"><strong>Change Password</strong></h2></legend><br>
<form method="post" autocomplete="off">
    <div class="wrapper">
        <div class="form-group">
            <label for="password">Old Password</label>
            <input type="password" name="password" maxlength="30" class="form-control" placeholder="Enter old password">
            <?php $html->err_msg($err, 'password') ?>
        </div>
        <div class="form-group">
            <label for="new">New Password</label>
            <input type="password" name="new" maxlength="30" class="form-control" placeholder="Enter new password">
            <?php $html->err_msg($err, 'new') ?>
        </div>
        <div class="form-group">
            <label for="confirm">Confirm New Password</label>
            <input type="password" name="confirm" maxlength="30" class="form-control" placeholder="Enter new confirm password">
            <?php $html->err_msg($err, 'confirm') ?>
        </div>
        <div class="text-center">
            <a href="/index.php" class="btn btn-secondary back">Back</a>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
    </div>
</form>
</fieldset>

<?php
$page->footer();
?>
