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

<p>
    <a href="?">All<a/>
        <a href="?category=L">Laptop</a>
        <a href="?category=K">Keyboard</a>
        <a href="?category=M">Mouse</a>
        <a href="?category=H">Headset</a>

</p>

<?php

foreach ($products as $p) {
    echo "
        <a class='product' href='product.php?id=$p->id'>
            <img src='cover/'>
            <div>$p->name</div>
        </a>
    ";
}
?>









<?php

$page->footer();
?>





















