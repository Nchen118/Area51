<?php
include 'configLibrary.php';
$page->authorize('admin');
$pdo = $page->pdo();

$stm = $pdo->query("SELECT * FROM `transaction`");
$transactions = $stm->fetchAll();

$page->title = 'Transcation History';
$page->header();
?>

<div class="jumbotron text-body">
    <table class="table table-hover table-bordered table-striped">
        <thead class="bg-dark text-light text-center">
            <tr>
                <th>Transaction ID</th>
                <th>Payment Date</th>
                <th>Total Price (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($transactions as $v) {
                echo "
                    <tr>
                        <td class='text-right'>$v->id</td>
                        <td class='text-right'>$v->payment_date</td>
                        <td class='text-right'>$v->total</td>
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
