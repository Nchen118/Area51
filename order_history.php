<?php
include 'configLibrary.php';
$page->authorize('admin');

$search = '';
$pdo = $page->pdo();

$stm = $pdo->prepare("SELECT * FROM `order`");
$stm->execute();
$products = $stm->fetchAll();

if ($page->is_post()) {
    $search = $page->post('search');
    $stm = $pdo->prepare("SELECT * FROM `order` WHERE (id=? OR product_id LIKE '%$search%')");
    $stm->execute([$search]);
    $products = $stm->fetchAll();
}



$page->title = 'View Product';
$page->header();
?>
<form method="post">
    <div class="wrapper form-group">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search Order History" value="<?= $search ?>">
            <div class="input-group-prepend">
                <span type="submit" class="input-group-text"><i class="material-icons">search</i></span>
            </div>
        </div>
    </div>
</form>
<div class="jumbotron text-body">
    <table class="table table-hover table-bordered">
        <thead class="bg-dark text-light text-center">
            <tr>
                <th>Order Id      </th>
                <th>Product Id</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $v) {
                echo "
                    <tr>
                        <td>$v->id</td>
                        <td>$v->product_id</td>
                        <td class='text-center'>
                            <a href='order_change.php?id=$v->id' class='btn btn-secondary' style='display: inline;'>Edit</a>
                            <a href='' class='btn btn-danger' style='display: inline;'>Delete</a>
                        </td>
                    </tr>
                ";
            }
            ?>
        </tbody>
    </table>
</div>




<?php
$page->footer();
?>