<?php
include '../configLibrary.php';
$page->authorize('customer');
$err = array();
$pdo = $page->pdo();
$photo = "no-photo.png";
$states = array(
    "SL" => "Selangor",
    "KL" => "Wilayah Persekutuan",
    "SW" => "Sarawak",
    "JH" => "Johor",
    "PN" => "Penang",
    "SB" => "Sabah",
    "PR" => "Perak",
    "PH" => "Pahang",
    "NS" => "Negeri Sembilan",
    "KD" => "Kedah",
    "ML" => "Malacca",
    "TR" => "Terengganu",
    "KT" => "Kelantan",
    "PL" => "Perlis"
);
// POST request (update) -------------------------------------------------------
if ($page->is_post()) {

    $email = $page->post('email');
    $phone = $page->post('ph_number');
    $firstName = $page->post('first_name');
    $lastName = $page->post('last_name');
    $address = $page->post('address');
    $city = $page->post('city');
    $postCode = $page->post('post_code');
    $state = $page->post('state');
    $file = $_FILES['file']; // Photo
    // TODO: Select photo
    $stm = $pdo->prepare("SELECT profile_pic FROM customer WHERE username = ?");
    $stm->execute([$page->user->name]);
    $photo = $stm->fetchColumn();

    if (strlen($firstName) > 50) {
        $err['first_name'] = 'First Name must not more than 50 characters.';
    }
    
    if (strlen($lastName) > 50) {
        $err['last_name'] = 'Last Name must not more than 50 characters.';
    }
    
    if (strlen($address) > 100) {
        $err['address'] = 'Address must not more than 100 characters.';
    }
    
    if (strlen($city) > 30) {
        $err['city'] = 'City must not more than 30 characters.';
    }
    
    if ($postCode != '' && !preg_match("/^\d{5}$/", $postCode)) {
        $err['post_code'] = 'Please enter 5 number only';
    }
    
    if (in_array($state, $states)) {
        $err['state'] = 'Choose a valid state';
    }

    if (!preg_match('/^01\d-\d{7,8}$/', $phone)) {
        $err['phone'] = 'Phone format invalid.';
    }

    // TODO: Validate file only if a file is uploaded
    //       Since it is optional to replace photo
    if ($file['name']) {
        if ($file['error'] == UPLOAD_ERR_FORM_SIZE ||
                $file['error'] == UPLOAD_ERR_INI_SIZE) {
            $err['file'] = 'Photo exceeds size allowed.';
        } else if ($file['error'] != UPLOAD_ERR_OK) {
            $err['file'] = 'Photo failed to upload.';
        } else {
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
                    ->toFile("../picture/$photo", 'image/jpeg');

            // TODO: Update session
            $_SESSION['photo'] = $photo;
        }

        // (2) Update member record
        $stm = $pdo->prepare("
            UPDATE `customer`
            SET `email` = ?, `ph_number` = ?, `profile_pic` = ?, `first_name` = ?, `last_name` = ?, `address` = ?, `city` = ?, `post_code` = ?, `state` = ?
            WHERE username = ?
        ");
        $stm->execute([$email, $phone, $photo, $firstName, $lastName, $address, $city, $postCode, $state, $page->user->name]);

        $page->temp('success', 'Profile changed.');
        $page->redirect('../index.php');
    }
}

if (isset($page->user->name)) {
    // TODO: Select member record
    $stm = $pdo->prepare("SELECT * FROM customer WHERE username = ?");
    $stm->execute([$page->user->name]);
    $m = $stm->fetch();

    $phone = $m->ph_number;
    $firstName = $m->first_name;
    $lastName = $m->last_name;
    $address = $m->address;
    $city = $m->city;
    $postCode = $m->post_code;
    $state = $m->state;
}

$page->title = 'Change Profile';
$page->header();
?>
<p class="success"><?= $page->temp('success') ?></p>
<h2>Change Profile</h2>
<form method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="jumbotron" id="change_profile">
        <div class="row form-group">
            <div class="col-3 text-right">First Name</div>
            <?php $html->text('first_name', $firstName, 50, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'first_name') ?>
        </div>        
        <div class="row form-group">
            <div class="col-3 text-right">Last Name</div>
            <?php $html->text('last_name', $lastName, 50, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'last_name') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Email</div>
            <input type="email" name="email" maxlength="30" class="col-8 text-left form-control">
            <?php $html->err_msg($err, 'email') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Phone</div>
            <input type="text" name="phone" class="col-3 text-left form-control" maxlength="12" placeholder="01X-XXXXXXX">
            <?php $html->err_msg($err, 'ph_number') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Address</div>
            <?php $html->text('address', $address, 100, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'address') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">City</div>
            <?php $html->text('city', $city, 30, 'class="col-3 text-left form-control"') ?>
            <?php $html->err_msg($err, 'city') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Post Code</div>
            <input type="number" pattern="[0-9]" name="post_code" class="col-3 text-left form-control" maxlength="5" placeholder="Post Code" inputmode="numeric">
            <?php $html->err_msg($err, 'post_code') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">State</div>
            <?php $html->select('state', $states, $state, true, 'class="col-3 form-control"') ?>
            <?php $html->err_msg($err, 'state') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Photo</div>
            <label>
                <input type="file" id="file" name="file" accept="image/*" class="form-control-file border">
                <div>Select photo (optional)...</div>
                <img id="prev" src="/picture/<?= $photo ?>" width="150px" height="150px" class="border border-dark">
            </label>
            <?php $html->err_msg($err, 'file') ?>
        </div>
        <div class="text-center">
            <a href="javascript:history.back()" class="btn btn back">Back</a>
            <button type="submit" class="btn btn-primary">Change Profile</button>
        </div>
    </div>
</form>

<?php
$page->footer();
?>