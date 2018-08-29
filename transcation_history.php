<?php
include 'configLibrary.php';
$page->authorize('admin');
$pdo = $page->pdo();

$stm = $pdo->prepare("SELECT * FROM `transaction`");
$stm->execute();
$transactions = $stm->fetchAll();





$page->title = 'Transcation History';
$page->header();
?>

<div class="jumbotron text-body">
    <table class="table table-hover table-bordered">
        <thead class="bg-dark text-light text-center">
            <tr>
                <th>Transcation Id </th>
                <th>Payment Date</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($transactions as $v) {
                echo "
                    <tr>
                        <td>$v->id</td>
                        <td>$v->payment_date</td>
                        <td>$v->total</td>
                        
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
