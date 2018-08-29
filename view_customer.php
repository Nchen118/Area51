<?php
include 'configLibrary.php';
$page->authorize('admin');

$search = '';
$pdo = $page->pdo();

$stm = $pdo->prepare("SELECT * FROM customer");
$stm->execute();
$customers = $stm->fetchAll();

if ($page->is_post()) {
    $search = $page->post('search');
    $stm = $pdo->prepare("SELECT * FROM `customer` WHERE (id = ? OR username LIKE '%$search%' OR email LIKE '%$search%')");
    $stm->execute([$search]);
    $customers = $stm->fetchAll();
}

$page->title = 'View Customer';
$page->header();
?>
<form method="post">
    <div class="wrapper form-group">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search customer..." value="<?= $search ?>">
            <div class="input-group-prepend">
                <span type="submit" class="input-group-text"><i class="material-icons">search</i></span>
            </div>
        </div>
    </div>
</form>

<h2>Customer List</h2>

<div class="jumbotron text-body">
    <table class="table table-hover table-bordered">
        <thead class="bg-dark text-light text-center">
            <tr>
                <th>ID</th>
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
                        <td class='text-right'>$v->id</td>
                        <td>$v->username</td>
                        <td>$v->email</td>
                        <td class='text-center'>
                            <a href='' class='btn btn-secondary' style='display: inline;'>Edit</a>
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