<?php
include 'configLibrary.php';
$page->authorize('admin');

$search = '';
$pdo = $page->pdo();

$stm = $pdo->prepare("SELECT * FROM customer");
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
        <table class="table table-hover table-bordered">
            <thead class="bg-dark text-light text-center">
                <tr>
                    <th>Id      </th>
                    <th>Username</th>
                    <th>Email</th>
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