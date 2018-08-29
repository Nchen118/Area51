<?php
include 'configLibrary.php';
$page->authorize('admin');

$search = '';
$pdo = $page->pdo();
$s = $page->get('s', 'id');
    if (!preg_match('/^-?(id|name|description|brand|category|date|price|photo)$/', $s)) {
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
$stm = $pdo->prepare("SELECT * FROM `product` ORDER BY `$field` $order");
$stm->execute();
$products = $stm->fetchAll();

if ($page->is_post()) {
    $action = $page->post('action');
    if ($action == 'search') {
        $search = $page->post('search');
        $stm = $pdo->prepare("SELECT * FROM `product` WHERE (id = ? OR name LIKE '%$search%')");
        $stm->execute([$search]);
        $products = $stm->fetchAll();
    } else {
        $stm = $pdo->prepare("DELETE FROM `product` WHERE id = ?");
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
            <input type="text" name="search" class="form-control" placeholder="Search Product..." value="<?= $search ?>">
            <input type="hidden" name="action" value="search">
            <div class="input-group-prepend">
                <span type="submit" class="input-group-text"><i class="material-icons">search</i></span>
            </div>
        </div>
    </div>
</form>
<form method="post">
    <div class="jumbotron text-body">
        <table class="table table-hover table-bordered table-striped">
            <thead class="bg-dark text-light text-center">
                <tr>
                     <th><a class="<?= get_cls('id')       ?>" href="<?= get_href('id')       ?>">Product Id</a></th>
                     <th><a class="<?= get_cls('name')       ?>" href="<?= get_href('name')       ?>">Product Name</a></th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $v) {
                    echo "
                    <tr>
                        <td>$v->id</td>
                        <td>$v->name</td>
                        <td class='text-center'>
                            <a href='product_change.php?id=$v->id' class='btn btn-secondary' style='display: inline;'>Edit</a>
                            <button name='action' value='$v->id' class='btn btn-danger' style='display: inline; margin: 0;'>Delete</button>
                        </td>
                    </tr>
                ";
                }
                ?>
            </tbody>
        </table>
    </div>
</form>



<?php
$page->footer();
?>