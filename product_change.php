<?php
include 'configLibrary.php';
$page->authorize('admin');
$err = array();
$pdo = $page->pdo();
$photo = "no-photo.png";
$categorys = array(
    "LP" => "Laptop",
    "MS" => "Mouse",
    "KB" => "Keyboard",
    "HS" => "Headset",
);
// POST request (update) -------------------------------------------------------
if ($page->is_post()) {
    $name = $page->post('name');
    $description = $page->post('description');
    $brand = $page->post('brand');
    $category = $page->post('category');
    $date = $page->post('date');
    $price = $page->post('price');

    $file = $_FILES['file']; // Photo
    // TODO: Select photo
    $id = $page->get('id');
    $stm = $pdo->prepare("SELECT photo FROM product WHERE id = ?");
    $stm->execute([$id]);
    $photo = $stm->fetchColumn();

    if ($name == '') {
        $err['name'] = 'ProductName is required.';
    }

    if ($description == '') {
        $err['description'] = 'Description is required.';
    }

    if ($brand == '') {
        $err['brand'] = 'Brand is required.';
    }

    if ($category == '') {
        $err['category'] = 'Category is required.';
    }

    if ($date == '') {
        $err['date'] = 'Date required.';
    } else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $err['date'] = 'Date format Invalid';
    }

    if ($price == '') {
        $err['price'] = 'Price is required';
    } else if (!preg_match('/^\d{0,5}.\d{0,2}$/', $price)) {
        $err['price'] = 'Format Invalid';
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
            unlink($page->root . "/photo/$photo");

            $photo = uniqid() . '.jpg';
            $img = new SimpleImage();
            $img->fromFile($file['tmp_name'])
                    ->thumbnail(150, 150)
                    ->toFile($page->root . "/photo/$photo", 'image/jpeg');

            // TODO: Update session
            $_SESSION['photo'] = $photo;
        }

        // (2) Update member record
        $stm = $pdo->prepare("
            UPDATE product
            SET  name = ?, description = ?, brand = ?, category = ?, date = ?, price = ?, photo = ?
            WHERE id = ?
        ");
        $stm->execute([$name, $description, $brand, $category, $date, $price, $photo, $id]);

        $page->temp('success', 'Profile changed.');
        $page->redirect('/index.php');
    }
}

if ($page->is_get()) {
    $id = $page->get('id');
    if (!$id) {
        $page->redirect('/view_product.php');
    }
    $stm = $pdo->prepare("SELECT * FROM `product` WHERE id = ?");
    $stm->execute([$id]);
    $m = $stm->fetch();

    $name = $m->name;
    $description = $m->description;
    $brand = $m->brand;
    $category = $m->category;
    $date = $m->date;
    $price = $m->price;
    $photo = $m->photo;
}

$page->title = 'Change Profile';
$page->header();
?>
<?= $page->temp('success') ?>
<h2>Change Profile</h2>
<form method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="jumbotron text-body">
        <div class="row form-group">
            <div class="col-3 text-right">Name</div>
            <?php $html->text('name', $name, 50, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'name') ?>
        </div>        
        <div class="row form-group">
            <div class="col-3 text-right">Description</div>
            <?php $html->text('description', $description, 100, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'description') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Brand</div>
            <?php $html->text('brand', $brand, 100, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'brand') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Category</div>
            <?php $html->select('category', $categorys, $category, true, 'class="col-3 form-control"') ?>
            <?php $html->err_msg($err, 'category') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right" placeholder="YYYY-mm-DD">Date</div>
            <?php $html->text('date', $date, 10, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'date') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Price</div>
            <?php $html->text('price', $price, 100, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'price') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Photo</div>
            <label>
                <input type="file" id="file" name="file" accept="image/*" class="form-control-file border">
                <div>Select photo (optional)...</div>
                <img id="prev" src="/photo/<?= $photo ?>" width="150px" height="150px" class="border border-dark">
            </label>
            <?php $html->err_msg($err, 'file') ?>
        </div>
        <div class="text-center">
            <a href="javascript:history.back()" class="btn btn back">Back</a>
            <button type="submit" class="btn btn-primary">Change Profile</button>
        </div>
    </div>
</form>
<script>
    var img = $("#prev")[0];
    var src = img.src;

    img.onerror = function (e) {
        img.src = src;
        $("#file").val("");
    };

    $("#file").change(function (e) {
        var f = this.files[0] || new Blob();
        img.src = URL.createObjectURL(f);
    });
</script>
<?php
$page->footer();
?>
