<?php
include 'configLibrary.php';

$products = $search = '';
$pdo = $page->pdo();

if ($page->is_post()) {
    $search = $page->post('search');
    $stm = $pdo->prepare("SELECT * FROM `product` WHERE `name` LIKE '%?%'");
    $stm->execute([$search]);
    $products = $stm->fetchAll();
}

if ($page->is_get()) {
    $categories = $page->get('category');
    $stm_cat = $pdo->prepare("SELECT * FROM category WHERE cat_key = ?");
    $stm_cat->execute([$categories]);
    $category = $stm_cat->fetch();

    $all = empty($category) ? 1 : 0;
    $stm_prod = $pdo->prepare("SELECT * FROM product WHERE category = ? OR ?");
    $stm_prod->execute([$categories, $all]);
    $products = $stm_prod->fetchAll();
}

$page->title = 'Product';
$page->header();
?>
<form method="POST" autocomplete="off">
    <div class="wrapper">
        <div class="input-group mb-3">
            <input type="text" id="search" name="search" value="<?= $search ?>" class="form-control" placeholder="Search">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">search</i></span>
            </div>
        </div>
    </div>
</form>
<br><hr>
<div class="d-flex flex-wrap justify-content-center">
    <?php foreach ($products as $p) { ?>
        <div class="product">
            <a href='product_detail.php?id=<?= $p->id ?>'>
                <img src='/photo/<?= $p->photo ?>' width="150px" height="150px" class="mx-auto d-block">
                <hr>
                <div class="text-center"><?= $p->name ?></div>
            </a>
        </div>
    <?php } ?>
</div>

<?php
$page->footer();
?>


