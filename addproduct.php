<?php
include 'configLibrary.php';

/* $productid = */ $productname = $description = $brand = $category = $date = $price = $photo = '';
$err = [];
$pdo = $page->pdo();

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
    } else if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
        $err['date'] = 'Date format Invalid';
    }

    if ($price == '') {
        $err['price'] = 'Price is required';
    } else if (!preg_match('/^RM\d{0,5}$/', $price)) {
        $err['price'] = 'Format Invalid';
    }

    if ($file['error'] == UPLOAD_ERR_NO_FILE) {
        $err['file'] = 'Photo is required.';
    } else if ($file['error'] == UPLOAD_ERR_FORM_SIZE ||
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

    if (!$err) {

        $photo = uniqid() . '.jpg';
        $img = new SimpleImage();
        $img->fromFile($file['tmp_name'])
                ->thumbnail(150, 150)
                ->toFile("productphoto/$photo", 'image/jpeg');

        // (3) Insert product record
        $stm = $pdo->prepare("
                INSERT INTO product (name, description, brand, category, date, price, photo)
                VALUES ( ?, ?, ?, ?, ?, ?, ?)
            ");
        $stm->execute([ $productname, $description, $brand, $category, $date, $price, $photo]);

        $page->temp('success', 'Product added.');
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

<p class="success"><?= $page->temp('success') ?></p>

<form method="post" enctype="multipart/form-data">
    <div class="form">

        <div>
            <label for="productname">Product Name</label>
            <?php $html->text('productname', $productname) ?>
            <?php $html->err_msg($err, 'productname') ?>
        </div>
        <div>
            <label for="description">Description</label>
            <?php $html->text('description', $description) ?>
            <?php $html->err_msg($err, 'description') ?>
        </div>
        <div>
            <label for="brand">Brand</label>
            <?php $html->text('brand', $brand) ?>
            <?php $html->err_msg($err, 'brand') ?>
        </div>
        <div>
            <label for="category">Category</label>
            <?php $html->text('category', $category) ?>
            <?php $html->err_msg($err, 'category') ?>
        </div>
        <div>
            <label for="date">Date</label>
            <?php $html->text('date', $date) ?>
            <?php $html->err_msg($err, 'date') ?>
        </div>
        <div>
            <label for="price">Price</label>
            <?php $html->text('price', $price) ?>
            <?php $html->err_msg($err, 'price') ?>
        </div>
        <div>
            <label for="file">Photo</label>
            <label>
                <input type="file" id="file" name="file" accept="image/*">
                <div>Select photo...</div>
                <img id="prev" src="/img/nophoto.png">
            </label>
            <?php $html->err_msg($err, 'file') ?>
        </div>
    </div>

    <button>Register</button>
    <button type="reset">Reset</button>
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
$html->focus('username', $err);
$page->footer();
?>














































