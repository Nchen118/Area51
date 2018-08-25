<?php

include '../configLibrary.php';
$page->authorize('customer');
$err = array();
$pdo = $page->pdo();
// POST request (update) -------------------------------------------------------
if ($page->is_post()) {
 
    $email = $page->post('email');
    $phone = $page->post('ph_number');
    $firstName=$page->post('first_name');
    $lastName=$page->post('last_name');
    $address=$page->post('address');
    $city=$page->post('city');
    $postCode=$page->post('post_code');
    $state=$page->post('state');
    $file  = $_FILES['file']; // Photo
    
    // TODO: Select photo
    $stm = $pdo->prepare("SELECT profile_pic FROM customer WHERE username = ?");
    $stm->execute([$page->user->name]);
    $photo = $stm->fetchColumn();
    
   
    if($firstName == ''){
        $err['first_name']='first name is required';
    }
    else if (strlen($firstName) > 100) {
        $err['first_name'] = 'First Name must not more than 100 characters.';
    }
     if($lastName == ''){
        $err['last_name']='Last name is required';
    }
    else if (strlen($lastName) > 100) {
        $err['last_name'] = 'Last Name must not more than 100 characters.';
    }
     if($address == ''){
        $err['address']='address is required';
    }
    else if (strlen($address) > 100) {
        $err['address'] = 'Address must not more than 100 characters.';
    }
     if($city == ''){
        $err['city']='City is required';
    }
    else if (strlen($city) > 100) {
        $err['city'] = 'City must not more than 100 characters.';
    }
     if($postCode == ''){
        $err['post_code']='Post Code is required';
    }
    else if (strlen($postCode) > 5) {
        $err['post_code'] = 'Post Code must not more than 100 characters.';
    }
     if($state == ''){
        $err['state']='State is required';
    }
    else if (strlen($state) > 100) {
        $err['state'] = 'State must not more than 100 characters.';
    }
    if ($email == '') {
        $err['email'] = 'Email is required.';
    }
    else if (strlen($email) > 100) {
        $err['email'] = 'Email must not more than 100 characters.';
    }
    else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $err['email'] = 'Email format invalid.';
    }
    
    if ($phone == '') {
        $err['phone'] = 'Phone is required.';
    }
    else if (!preg_match('/^01\d-\d{7,8}$/', $phone)) {
        $err['phone'] = 'Phone format invalid.';
    }

    // TODO: Validate file only if a file is uploaded
    //       Since it is optional to replace photo
    if ($file['name']) {
        if ($file['error'] == UPLOAD_ERR_FORM_SIZE ||
            $file['error'] == UPLOAD_ERR_INI_SIZE) {
            $err['file'] = 'Photo exceeds size allowed.';
        }
        else if ($file['error'] != UPLOAD_ERR_OK) {
            $err['file'] = 'Photo failed to upload.';
        }
        else {
            // NOTE: Remember to enable "fileinfo" extension in "php.ini"
            $mime = mime_content_type($file['tmp_name']);
            if ($mime != 'image/jpeg' && $mime != 'image/png') {
                $err['file'] = 'Only JPEG or PNG photo allowed.';
            }
        }
    }
     if (!$err) {
        // TODO: Update member record
        
        // (1) Photo
        if ($file['name']) {
            // TODO: Delete old photo
            unlink("../photo/$photo");
            
            $photo = uniqid() . '.jpg';
            $img = new SimpleImage();
            $img->fromFile($file['tmp_name'])
                ->thumbnail(150, 150)
                ->toFile("../photo/$photo", 'image/jpeg');
            
            // TODO: Update session
            $_SESSION['photo'] = $photo;
        }
        
        // (2) Update member record
        $stm = $pdo->prepare("
            UPDATE customer
            SET email = ?, ph_number = ?, profile_pic = ?, first_name = ?, last_name = ?, address = ?, city = ?, post_code = ?, state = ?
            WHERE username = ?
        ");
        $stm->execute([$email, $phone, $photo,$firstName,$lastName,$address,$city,$postCode,$state,$page->user->name]);
        
        $page->temp('success', 'Profile changed.');
        $page->redirect('../index.php');
    }
}
    
    




// GET request (select) --------------------------------------------------------
if (isset($page->user->name)) {
    // TODO: Select member record
    $stm = $pdo->prepare("SELECT * FROM customer WHERE username = ?");
    $stm->execute([$page->user->name]);
    $m = $stm->fetch();
      
    $username=$m->username;
    $email = $m->email;
    $phone = $m->ph_number; 
    $photo = $m->profile_pic;
    $firstName=$m->first_name;
    $lastName=$m->last_name;
    $address=$m->address;
    $city=$m->city;
    $postCode=$m->post_code;
    $state=$m->state;
}


$page->title = 'Change Profile';
$page->header();
?>
<p class="success"><?= $page->temp('success') ?></p>

<form method="post" enctype="multipart/form-data">
    <div class="form">
        <div>
            <label for="username">Username</label>
            <?php $html->text('username', $username, 100, 'disabled') ?>
            <?php $html->err_msg($err, 'username') ?>
        </div>
        <div>
            <label for="first_name">First Name</label>
            <?php $html->text('first_name', $firstName, 100) ?>
            <?php $html->err_msg($err, 'first_name') ?>
            
        </div>
        <div>
            <label for="last_name">Last Name</label>
            <?php $html->text('last_name', $lastName, 100) ?>
            <?php $html->err_msg($err, 'last_name') ?>
            
        </div>
        <div>
            <label for="email">Email</label>
            <?php $html->text('email', $email, 100) ?>
            <?php $html->err_msg($err, 'email') ?>
        </div>
        <div>
            <label for="ph_number">Phone</label>
            <?php $html->text('ph_number', $phone, 12) ?>
            <?php $html->err_msg($err, 'ph_number') ?>
        </div>
        <div>
            <label for="address">Address</label>
            <?php $html->text('address',$address,100) ?>
            <?php $html->err_msg($err,'address') ?>
        </div>
        <div>
            <label for="city">City</label>
            <?php $html->text('city',$city,100 )?>
            <?php $html->err_msg($err,'city') ?>
        </div>
        <div>
            <label for="post_code">Post Code</label>
            <?php $html->text('post_code',$postCode,5) ?>
            <?php $html->err_msg($err,'post_code') ?>
        </div>
        <div>
            <label for="state">State</label>
            <?php $html->text('state',$state,20) ?>
            <?php $html->err_msg($err,'state') ?>
        </div>
        <div>
            <label for="file">Photo</label>
            <label>
                <input type="file" id="file" name="file" accept="image/*">
                <div>Select photo (optional)...</div>
                <!-- TODO: Photo path -->
                <img id="prev" src="/photo/<?= $photo ?>">
            </label>
            <?php $html->err_msg($err, 'file') ?>
        </div>
    </div>
    
    <button>Change Profile</button>
    <button type="reset">Reset</button>
</form>






<?php

$page->footer();
    ?>