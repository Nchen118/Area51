<?php

include 'configLibrary.php';

if ($page->is_get()) {
    $category = $page->get('category');
    $all = ($category != 'L' && $category != 'M' && $category != 'K' && $category != 'H'); // true or false

    $pdo = $page->pdo();
    $stm = $pdo->prepare("SELECT * FROM product WHERE category = ? OR ?");
    $stm->execute([$category, $all]);
    $products = $stm->fetchAll();
}


$page->title = 'Product';
$page->header();
?>

<?php foreach ($products as $p) {?>
    <a class='product' href='product.php?id=<?= $p->id ?>'>
        <img src='/photo/<?= $p->photo ?>'>
        <div><?= $p->name ?></div>
    </a>
<?php } ?>


<?php

$page->footer();
?>