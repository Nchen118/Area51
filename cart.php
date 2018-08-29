<?php
include 'configLibrary.php';

// POST request ----------------------------------------------------------------
if ($page->is_post()) {
    // TODO
    $action = $page->post('action');
    if ($action == 'update') {
        $id = $page->post('id');
        $quantity = $page->post('quantity');
        $cart->set($id, $quantity);
        if ($quantity == 0) {
            if ($page->user && $page->user->is_customer){
                $pdo = $page->pdo();
                $stm = $pdo->prepare("DELETE FROM `cart` WHERE `prod_id` = ?");
                $stm->execute([$id]);
            }
        }
        else {
            if ($page->user && $page->user->is_customer){
                $pdo = $page->pdo();
                $stm = $pdo->prepare("UPDATE `cart` SET `qty` = ? WHERE `prod_id` = ?");
                $stm->execute([$quantity, $id]);
            }
        }
        $page->redirect();
    }
    if ($action == 'clear') {
        $page->redirect('/');
    }
    if ($action == 'checkout') {
        $page->redirect('checkout.php');
    }
}

// GET request -----------------------------------------------------------------
// TODO
$ids = $cart->ids();
$in = '(' . str_repeat('?,', count($ids)) . '1)';
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE id IN $in");
$stm->execute($ids);
$Cart = $stm->fetchAll();

// UI --------------------------------------------------------------------------
$page->title = 'Cart';
$page->header();
?>

<style>
    .cover {
        border: 1px solid #ccc;
        width: 150px; height: 150px;
        /* TODO */
        position:absolute;
        transform: translate(0,-50%);
        display:none;
    }
    tr:hover .cover{
        display:block;
    }
</style>
<h2>Checkout</h2>
<!-- IF: Shopping cart NOT EMPTY ---------------------------------------------->
<?php if ($cart->items): ?>

    <table class="table table-dark table-striped table-bordered table-hover">
        <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Price(RM)</th>
            <th>Quantity</th>
            <th>Subtotal(RM)</th>
            <th></th>
        </tr>

        <?php
        // TODO
        $total_quantity = 0;
        $total = 0.00;

        foreach ($Cart as $p) {
            $quantity = $cart->get($p->id);
            $subtotal = $p->price * $quantity;

            $total_quantity += $quantity;
            $total += $subtotal;
            ?>
            <tr class="text-right">
                <td>
                    <a href="product_detail.php?id=<?= $p->id ?>"><?= $p->id ?></a>
                </td>
                <td><?= $p->name ?></td>
                <td><?= $p->price ?></td>
                <td>
                    <!-- TODO -->
                    <form method="post" class="inline">
                        <?php $html->select('quantity', range(0, 10), $quantity, false, 'onchange="this.form.submit()" class="form-control"') ?>
                        <?php $html->hidden('id', $p->id) ?>
                        <?php $html->hidden('action', 'update') ?>
                    </form>
                </td>
                <td><?= number_format($subtotal, 2) ?></td>
                <td class="text-center">
                    <img src='/photo/<?= $p->photo ?>' width="100" height="100">

                </td>
            </tr>
        <?php } // END FOREACH  ?>

        <tr class="text-right">
            <th colspan="3">Total: </th>
            <th><?= $total_quantity ?></th>
            <th>RM <?= number_format($total, 2) ?></th>
            <th></th>
        </tr>
    </table>

    <p style="color: red">NOTE: Set quantity to 0 to remove item.</p>

    <form method="post">
        <div class="text-center">
            <button name="action" value="clear" class="btn btn-secondary button-size">Back</button>
            <button name="action" value="checkout" class="btn btn-primary button-size">Checkout</button>
        </div>
    </form>

    <!-- ELSE: Shopping cart EMPTY ------------------------------------------------>
<?php else: ?>
    <div class="jumbotron text-body">
        <p>Your shopping cart is empty.</p>
    </div>
<?php endif; ?>
<!-- END IF ------------------------------------------------------------------->

<?php
$page->footer();
?>
