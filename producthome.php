<?php
include 'configLibrary.php';

//==========================================================================
$category = $page->get('category');
$all = ($category != 'L' && $category != 'M' && $category != 'K' && $category != 'H'); // true or false

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE category = ? OR ?");
$stm->execute([$category, $all]);
$products = $stm->fetchAll();

//==============================================================================
$page->title = 'Product';
$page->header();
?>
<style>
    .dropproduct {
        position: relative;
        display: inline-block;
    }

    .dropproduct-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }


    .dropproduct:hover .drsspproduct-content {display: block;}
</style>
<p>
<div class="dropproduct">
    <a href="?">All<a/>
        <a>Product</a>
        <div class="dropproduct-content">
            <a href="?category=L">Laptop</a>
            <a href="?category=K">Keyboard</a>
            <a href="?category=M">Mouse</a>
            <a href="?category=H">Headset</a>
        </div>
</div>
</p>


<?php foreach ($products as $p) { ?>
    <a class='product' href='product.php?id=<?= $p->id ?>'>
        <img src='/productphoto/<?= $p->photo ?>'>
        <div><?= $p->name ?></div>
    </a>
<?php } ?>









<?php
$page->footer();
?>


































