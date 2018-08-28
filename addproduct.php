<?php
include 'configLibrary.php';

$page->authorize('admin');

/* $productid = */ $productname = $description = $brand = $category = $date = $price = $photo = '';
$err = [];
$mime = '';
$pdo = $page->pdo();

$stm = $pdo->prepare("SELECT cat_key FROM category");
$stm->execute([]);
$cat_key = $stm->fetchAll(PDO::FETCH_COLUMN, 0);
$stm = $pdo->prepare("SELECT cat_name FROM category");
$stm->execute([]);
$cat_name = $stm->fetchAll(PDO::FETCH_COLUMN, 0);

for ($index = 0; $index < count($cat_key); $index++) {
    $cat[$cat_key[$index]] = $cat_name[$index];
}

if ($page->is_post()) {
    /* $productid = $page->post('productid'); */
    $productname = $page->post('productname');
    $description = $page->post('description');
    $brand = $page->post('brand');
    $category = $page->post('category');
    $date = $page->post('date');
    $price = $page->post('price');
    $file = $_FILES['file']; // Photo

    /* if ($productid == '') {
      $err['productid'] = 'Product ID is required.';
      } else if (!preg_match('/^\S+$/', $productid)) {
      $err['productid'] = 'Product ID cannot contain spaces.';
      }
     */
    if ($productname == '') {
        $err['productname'] = 'ProductName is required.';
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

    if ($file['error'] == UPLOAD_ERR_NO_FILE) {
        $err['file'] = 'Photo is required.';
    } else if ($file['error'] == UPLOAD_ERR_FORM_SIZE || $file['error'] == UPLOAD_ERR_INI_SIZE) {
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

    if (!$err) {
        if ($mime == 'image/jpeg') {
            $photo = uniqid() . '.jpg';
            $img = new SimpleImage();
            $img->fromFile($file['tmp_name'])
                    ->thumbnail(150, 150)
                    ->toFile($page->root . "/photo/$photo", 'image/jpeg');
             // TODO: Update session
            $_SESSION['photo'] = $photo;
        
        } else if ($mime == 'image/png') {
            $photo = uniqid() . '.png';
            $img = new SimpleImage();
            $img->fromFile($file['tmp_name'])
                    ->thumbnail(150, 150)
                    ->toFile($page->root . "/photo/$photo", 'image/png');
        }
        // (3) Insert product record
        $stm = $pdo->prepare("
            INSERT INTO product (name, description, brand, category, date, price, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stm->execute([$productname, $description, $brand, $category, $date, $price, $photo]);

        $page->temp('success', 'Product added.');
        $page->redirect('/product.php');
    }
}
/* script for product of below
  <div>
  <label for="productid">Product ID</label>
  <?php $html->text('productid', $productid) ?>
  <?php $html->err_msg($err, 'productid') ?>
  </div>
 */
//==========================================================================


$page->title = 'ADD PRODUCT!!!';
$page->header();
?>

<style>
    #file {
        display: none;
    }

    #prev {
        width: 150px; height: 150px;
        display: block;
        border: 1px solid #999;
        object-fit: cover;
    }
</style>
<div class="jumbotron text-body">
<p class="success"><?= $page->temp('success') ?></p>
<h2 class="text-center">Add Product</h2><br>
<form method="post" enctype="multipart/form-data">
    <div class="wrapper">

        <div class="form-group">
            <label for="productname">Product Name</label>
            <?php $html->text('productname', $productname, 100, 'class="form-control"') ?>
            <?php $html->err_msg($err, 'productname') ?>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <?php $html->text('description', $description, 255, 'class="form-control"') ?>
            <?php $html->err_msg($err, 'description') ?>
        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <?php $html->text('brand', $brand, 100, 'class="form-control"') ?>
            <?php $html->err_msg($err, 'brand') ?>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <?php $html->select('category', $cat, $category, true, 'class="form-control"') ?>
            <?php $html->err_msg($err, 'category') ?>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" value="<?= $date ?>" class="form-control">
            <?php $html->err_msg($err, 'date') ?>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">RM</span>
                </div>
                <input type="number" name="price" step="any" value="<?= $price ?>" class="form-control">
            </div>
            <?php $html->err_msg($err, 'price') ?>
        </div>
        <div class="form-group">
            <label for="file">Photo</label>
            <label>
                <input type="file" id="file" name="file" accept="image/*" class="form-control-file border">
                <div>Select photo...</div>
                <img id="prev" src="/img/nophoto.png" width="150px" height="150px" class="border border-dark">
            </label>
            <?php $html->err_msg($err, 'file') ?>
        </div>
        <div class="form-group text-center">
            <a href="/index.php" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-primary">Register</button>
        </div>
    </div>
</form>
</div>
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
$html->focus('username', $err);
$page->footer();
?>