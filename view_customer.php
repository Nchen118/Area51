<?php
include 'configLibrary.php';
$page->authorize('admin');

$search = '';
$pdo = $page->pdo();
$s = $page->get('s', 'id');
    if (!preg_match('/^-?(id|username|password|email|ph_number|profile_pic|first_name|last_name|address|city|post_code|state)$/', $s)) {
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
$stm = $pdo->prepare("SELECT * FROM customer ORDER BY `$field` $order");
$stm->execute();
$customers = $stm->fetchAll();

if ($page->is_post()) {
    $action = $page->post('action');
    if ($action == 'search') {
        $search = $page->post('search');
        $stm = $pdo->prepare("SELECT * FROM `customer` WHERE (id = ? OR username LIKE '%$search%' OR email LIKE '%$search%')");
        $stm->execute([$search]);
        $customers = $stm->fetchAll();
    } else {
        $stm = $pdo->prepare("DELETE FROM `customer` WHERE id = ?");
        $stm->execute([$action]);
        $page->temp('success', 'Delete successful');
        $page->redirect();
    }
}

$page->title = 'View Customer';
$page->header();
?>

<?= $page->temp('success') ?>
<form method="post">
    <div class="wrapper form-group">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search customer..." value="<?= $search ?>">
            <input type="hidden" name="action" value="search">
            <div class="input-group-prepend">
                <span type="submit" class="input-group-text"><i class="material-icons">search</i></span>
            </div>
        </div>
    </div>
</form>

<h2>Customer List</h2>

<form method="post">
    <div class="jumbotron text-body">
        <table class="table table-hover table-bordered table-striped">
            <thead class="bg-dark text-light text-center">
                <tr>
                   <th><a class="<?= get_cls('id')       ?>" href="<?= get_href('id')       ?>">Customer Id</a></th>
                   <th><a class="<?= get_cls('username')       ?>" href="<?= get_href('username')       ?>">Username</a></th>
                   <th><a class="<?= get_cls('email')       ?>" href="<?= get_href('email')       ?>">Email</a></th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($customers as $v) {
                    echo "
                    <tr>
                        <td>$v->id</td>
                        <td>$v->username</td>
                        <td>$v->email</td>
                        <td class='text-center'>
                            <a href='customer_detail.php?username=$v->username' class='btn btn-secondary' style='display: inline;'>Edit</a>
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