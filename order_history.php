<?php
include 'configLibrary.php';
$page->authorize('admin');

$search = '';
$pdo = $page->pdo();

$stm = $pdo->prepare("SELECT * FROM `order`");
$stm->execute();
$products = $stm->fetchAll();

if ($page->is_post()) {
    $action = $page->post('action');
    if ($action == 'search') {
        $search = $page->post('search');
        $stm = $pdo->prepare("SELECT * FROM `order` WHERE (id = ? OR product_id LIKE '%$search%')");
        $stm->execute([$search]);
        $products = $stm->fetchAll();
    } else {
        $stm = $page->post("DELETE FROM `order` WHERE id = ?");
        $stm->execute([$action]);
        $page->temp('success', 'Delete successful');
        $page->redirect();
    }
}

$page->title = 'View Product';
$page->header();
?>
<?= $page->temp('success') ?>
<form method="post">
    <div class="wrapper form-group">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search Order History" value="<?= $search ?>">
            <input type="hidden" name="action" value="search">
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
                <th>Order Id</th>
                <th>Product Id</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $v) {
                echo "
                    <tr class='text-center'>
                        <td>$v->id</td>
                        <td>$v->product_id</td>
                        <td class='text-center'>
                            <a href='order_change.php?id=$v->id' class='btn btn-secondary' style='display: inline;'>Edit</a>
                            <button name='action' value='$v->id' class='btn btn-danger' style='display: inline; margin: 0;'>Delete</button>
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