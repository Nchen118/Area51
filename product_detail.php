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
    $id = $page->post('id');
    $quantity = $page->post('quantity');
    $cart->set($id, $quantity);

    $page->temp('success', 'Shopping cart updated.');
    $page->redirect();
}

// GET request -----------------------------------------------------------------
if ($page->is_get()) {
    $id = $page->get('id');
    $stm = $pdo->prepare("SELECT * FROM product WHERE id = ?");
    $stm->execute([$id]);
    $p = $stm->fetch();
    if ($p == null) {
        $page->redirect('/'); // Redirect to "index.php"
    }
}

// UI --------------------------------------------------------------------------
$page->title = '<PRODUCT DETAIL>';
$page->header();
?>
<?= $page->temp('success') ?>

<form>
    <div class="jumbotron text-body">
        <div>
            <label>Photo</label>
            <img class="photo" src='/photo/<?= $p->photo ?>'>
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
            <div><?= $p->category ?> - <?= $cat[$p->category] ?></div>
        </div>
        <div>
            <label>Date</label>
            <div><?= $p->date ?></div>
        </div>
        <div>
            <label>Price</label>
            <div>RM <?= $p->price ?></div>
        </div>
        <div>
        <label>Quantity</label>
        <div>
           
            <form method="post">
                <?php $html->select('quantity', range(0, 10), $cart->get($p->id),
                                    false, 'onchange="this.form.submit()"') ?>
                <?php $html->hidden('id', $p->id) ?>
            </form>
        </div>
    </div>

    </div>

    <button data-get="/">Back</button>
</form>
<?php
$page->footer();
?>
