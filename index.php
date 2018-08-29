<?php
include 'configLibrary.php';

$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT `photo` FROM `product` ORDER BY `id` DESC LIMIT 3");
$stm->execute();
$products = $stm->fetchALL(PDO::FETCH_COLUMN, 0);

$page->title = 'Home';
$page->header();
?>
<div id="display" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators">
        <li data-target="#display" data-slide-to="0" class="active"></li>
        <li data-target="#display" data-slide-to="1"></li>
        <li data-target="#display" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner text-center">
        <div class="carousel-item active">
            <div class="slide_wrap">
                <img src="/photo/<?= $products[0] ?>" width="180px" height="180px" class="img-fluid">
            </div>
        </div>
        <div class="carousel-item">
            <div class="slide_wrap">
                <img src="/photo/<?= $products[1] ?>" width="180px" height="180px" class="img-fluid">
            </div>
        </div>
        <div class="carousel-item">
            <div class="slide_wrap">
                <img src="/photo/<?= $products[2] ?>" width="180px" height="180px" class="img-fluid">
            </div>
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#display" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#display" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>
<hr>
<?php
$page->footer();
?>