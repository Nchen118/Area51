<?php
include '../configLibrary.php';
$page->authorize('customer');

$search = '';
$pdo = $page->pdo();
$s = $page->get('s', 'id');
    if (!preg_match('/^-?(id|personal_detail|transaction_id|product_id|delivery_notes|delivery_time|delivery_day|created|quantity)$/', $s)) {
        $s = 'id';
    }
    
    if ($s[0] == '-') {
        $field = substr($s, 1);
        $order = 'DESC';
    }
    else {
        $field = $s;
        $order = 'ASC';
    }
    
    function get_href($f) {
        global $field, $order; // Use global variable
        if ($f == $field) {
            return $order == 'ASC' ? "?s=-$f" : "?s=$f";
        }
        else {
            return "?s=$f";
        }
    }
    
    function get_cls($f) {
        global $field, $order;
        if ($f == $field) {
            return $order; // ASC or DESC
        }
    }
$stm = $pdo->prepare("SELECT * FROM `order` ORDER BY `$field` $order");
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
//if($page->is_post()){
//    $id = $page->post
//}
$page->title = 'Order   History';
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
    <table class="table table-hover table-bordered table-striped">
        <thead class="bg-dark text-light text-center">
            <tr>
                <th><a class="<?= get_cls('id')       ?>" href="<?= get_href('id')       ?>">Order Id</a></th>
                <th><a class="<?= get_cls('product_id')       ?>" href="<?= get_href('product_id')       ?>">Product Id</a></th>
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

