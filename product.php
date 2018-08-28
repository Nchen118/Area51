<?php
include 'configLibrary.php';

$pdo = $page->pdo();

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


