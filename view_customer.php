<?php
include 'configLibrary.php';
$page->authorize('admin');
$pdo = $page->pdo();

if($page->is_get()){
    $id = $page->get('id');
    $stm= $pdo->prepare("SELECT * FROM customer where id = ?");
    $stm->execute[($id)];
    $a=$stm->fetchAll();
}


$page->title='View Customer';
$page->header();
?>
<div class="d-flex flex-wrap justify-content-center">
    <?php foreach ($a as $p) { ?>
        <div class="customer">
            <a href='customer_detail.php?id=<?= $p->id ?>'>
                <img src='/photo/<?= $p->photo ?>' width="150px" height="150px" class="mx-auto d-block">
                <hr>
                <div class="text-center"><?= $p->username ?></div>
            </a>
        </div>
<?php } ?>
</div>

<?php 
$page->footer();
?>