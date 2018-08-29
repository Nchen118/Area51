<?php
include 'configLibrary.php';

if ($page->is_post()) {
    $sql = file_get_contents('area_51.sql');
    $pdo = new PDO('mysql:host=localhost;port=3306', 'root', '');
    $pdo->exec($sql);
    
    $page->temp('success', 'Database restored.');
}

$page->title = 'Restore';
$page->header();
?>

<p class="success"><?= $page->temp('success') ?></p>

<p>Start MySQL and click the <b>Restore Database</b> button.<p>

<form method="post">
    <button>Restore Database</button>
</form>

<?php
$page->footer();
?>

