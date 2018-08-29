<?php
include 'configLibrary.php';

$pdo = $page->pdo();

$categories = $pdo->prepare("SELECT cat_key FROM category");
$categories->execute([]);
$cat_key = $categories->fetchAll(PDO::FETCH_COLUMN, 0);
$categories = $pdo->prepare("SELECT cat_name FROM category");
$categories->execute([]);
$cat_name = $categories->fetchAll(PDO::FETCH_COLUMN, 0);

for ($index = 0; $index < count($cat_key); $index++) {
    $cat[$cat_key[$index]] = $cat_name[$index];
}
// POST request ----------------------------------------------------------------
if ($page->is_post()) {
    // TODO
    $exist = false;
    $id = $page->get('id');
    if ($page->user != NULL && $page->user->is_customer) {
        $stm = $pdo->prepare("SELECT * FROM `cart` WHERE cust_name = ?");
        $stm->execute([$page->user->name]);
        $products = $stm->fetchAll();
        
        foreach($products as $values){
            if ($values->prod_id == $id) {
                $exist = true;
            }
        }
        
        if ($exist == false) {
            $stm = $pdo->prepare("INSERT INTO `cart`(`cust_name`, `prod_id`, `qty`) VALUES (?, ?, ?)");
            $stm->execute([$page->user->name, $id, 1]);
            $page->temp('success', 'Shopping cart updated.');
        }
        else {
            $page->temp('warning', 'Product is already in your cart.');
        }
    }
    if ($page->user == NULL) {
        $cart->set($id, 1);
        $page->temp('success', 'Shopping cart updated.');
    }
    $page->redirect();
}

// GET request -----------------------------------------------------------------
if ($page->is_get()) {
    $id = $page->get('id');
    $stm = $pdo->prepare("SELECT * FROM product WHERE id = ?");
    $stm->execute([$id]);
    $p = $stm->fetch();
    if ($p == null) {
        $page->redirect('/index.php'); // Redirect to "index.php"
    }
}

// UI --------------------------------------------------------------------------
$page->title = $p->name;
$page->header();
?>
<?= $page->temp('success') ?>
<?= $page->temp('warning') ?>

<form method="post">
    <div class="jumbotron text-body">
        <div class="form-group text-center">
            <img class="photo" src="/photo/<?= $p->photo ?>" alt="<?= $p->name ?>" title="<?= $p->name ?>">
        </div>
        <div class="row form-group">
            <label class="col-3 text-right">Product ID:</label>
            <b class="col-8 text-left"><?= $p->id ?></b>
        </div>
        <div class="row form-group">
            <label class="col-3 text-right">Product name:</label>
            <div class="col-8 text-left"><strong><?= $p->name ?></strong></div>
        </div>
        <div class="row form-group">
            <label class="col-3 text-right">Description:</label>
            <div class="col-8 text-left"><?= $p->description ?></div>
        </div>
        <div class="row form-group">
            <label class="col-3 text-right">Brand:</label>
            <div class="col-8 text-left"><?= $p->brand ?></div>
        </div>
        <div class="row form-group">
            <label class="col-3 text-right">Category:</label>
            <div class="col-8 text-left"><?= $p->category ?> - <?= $cat[$p->category] ?></div>
        </div>
        <div class="row form-group">
            <label class="col-3 text-right">Date:</label>
            <div class="col-8 text-left"><?= $p->date ?></div>
        </div>
        <div class="row form-group">
            <label class="col-3 text-right">Price:</label>
            <div class="col-8 text-left"><strong>RM <?= $p->price ?></strong></div>
        </div>
        <div class="form-group text-center">
            <button data-get="/" class="btn btn-secondary">Back</button>
            <button type="submit" class="btn text-light" style="background-color: orange">Add cart</button>
        </div>
    </div>
</form>
<?php
$page->footer();
?>
