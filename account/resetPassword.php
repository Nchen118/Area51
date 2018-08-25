<?php
include '../configLibrary.php';

$check = $email = '';
$err = [];

if ($page->is_post()) {
    $check = $page->post('forget_password');
    
    if ($check == '') {
        $err['error'] = 'Username or email is required.';
    }
 
    if (!$err) {
        // TODO: Reset password (update database and send email)
        $pdo = $page->pdo();
        
        // (1) Verify if username and email matched
        $stm = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
        $stm->execute([$check, $check]);
        $user = $stm->fetch();
        $email = $user->email;
        
        if ($user) {
            // (2) Generate random password --> hash
            $password = password_hash($page->random_password(), PASSWORD_DEFAULT);
            
            // (3) Update member or admin record
            $table = $user->role;
            $stm = $pdo->prepare("UPDATE $table SET password = ? WHERE username = ? OR email = ?");
            $stm->execute([$password, $check, $check]);
            
            // (4) Send email
            $ok = $page->email($email, 'Password Reset', "
                <p>Dear $user->name,</p>
                <p>Your password has been reset to:</p>
                <h1>$password</h1>
                <p>Please <a href='http://localhost:8000/account/login.php'>login</a> using your new password.</p>
                <p>From Admin</p>
            ");
                        
            if ($ok) {
                $page->temp('success', 'Password reset. Please check your email.');
                $page->redirect();
            }
            else {
                $err['email'] = 'Failed to send email.';    
            }
        }
        else {
            $err['email'] = 'Username and Email not matched.';
        }
    }
}

$page->title = 'Reset Password';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<form method="post" autocomplete="false">
    <div class="form">
        <div>
            <label for="username">Enter your username or email address</label>
            <input type="text" id="forget_password" name="forget_password" maxlength="50" value="">
            <?php $html->err_msg($err, 'error') ?>
        </div>
    </div>
    
    <button>Reset Password</button>
    <button type="reset">Reset</button>
</form>

<?php
$html->focus('username', $err);
$page->footer();
?>


