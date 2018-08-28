<?php
include 'configLibrary.php';

// POST request ----------------------------------------------------------------
if ($page->is_post()) {
    // TODO
    $id = $page->post('id');
    $quantity = $page->post('quantity');
    $cart->set($id, $quantity);
    
    $page->temp('success', 'Shopping cart updated.');
    $page->redirect();
}

// GET request -----------------------------------------------------------------
$id = $page->get('id');
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM prorduct WHERE id = ?");
$stm->execute([$id]);
$p = $stm->fetch();
if ($p == null) {
    $page->redirect('/'); // Redirect to "index.php"
}

// UI --------------------------------------------------------------------------
$page->title = '<PRODUCT DETAIL>';
$page->header();
?>

<style>
    .cover {
        border: 1px solid #ccc;
        width: 150px; height: 150px;
    }
</style>

<p class="success"><?= $page->temp('success') ?></p>

<div class="form">
    <div>
        <label>Photo</label>
        <img class="photo" src='/productphoto/<?= $p->photo ?>'>
    </div>
    <div>
        <label>Product ID</label>
        <b><?= $p->id ?></b>
    </div>
    <div>
        <label>Product name</label>
        <div><?= $p->name ?></div>
    </div>
    <div>
        <label>Description</label>
        <div><?= $p->description ?></div>
    </div>
    <div>
        <label>Brand</label>
        <div><?= $p->brand ?></div>
    </div>
    <div>
        <label>Category</label>
        <div><?= $p->category ?> - <?= $arr_category[$p->category] ?></div>
    </div>
    <div>
        <label>Date</label>
        <div><?= $p->date ?></div>
    </div>
    <div>
        <label>Price</label>
        <div>RM <?= $p->price ?></div>
    </div>
    
</div>

<p>
    <!-- Back to "index.php" -->
    <button data-get="/">Back</button>
</p>

<?php
$page->footer();
?>
