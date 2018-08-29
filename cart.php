<?php
include 'configLibrary.php';

$cart->dump();

// POST request ----------------------------------------------------------------
if ($page->is_post()) {
    // TODO
    $action = $page->post('action');
    if($action == 'update'){
        $id = $page->post('id');
        $quantity = $page->post('quantity');
        $cart->set($id,$quantity);
        $page->redirect();
    }
    if($action == 'clear'){
        $cart->clear();
        $page->redirect();
    }
    if($action == 'checkout'){
        $page->redirect('checkout.php');
    }
    
    
}

// GET request -----------------------------------------------------------------

// TODO
$ids = $cart->ids();
$in = '('.str_repeat('?,',count($ids)).'1)';
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

<!-- IF: Shopping cart NOT EMPTY ---------------------------------------------->
<?php if ($cart->items): ?>

<table class="table">
    <tr>
        <th>Id</th>        
        <th>Title</th>
        <th>Artist</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
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
        <tr>
            <td>
                <a href="album.php?id=<?= $p->id ?>"><?= $p->id ?></a>
            </td>
            <td><?= $p->id ?></td>
            <td><?= $p->name ?></td>
            <td><?= $p->price ?></td>
            <td>
                <!-- TODO -->
                <form method="post" class="inline">
                    <?php $html->select('quantity', range(0, 10), $quantity, false, 'onchange = "this.form.submit()"') ?>
                    <?php $html->hidden('id',$p->id)?>
                    <?php $html->hidden('action','update')?>
                </form>
            </td>
            <td><?= number_format($subtotal,2) ?></td>
            <td>
                <img src='/productphoto/<?= $p->photo ?>'>
                
            </td>
        </tr>
    <?php } // END FOREACH ?>
        
    <tr>
        <th colspan="4"></th>
        <th><?= $total_quantity ?></th>
        <th><?= number_format($total,2) ?></th>
        <th></th>
    </tr>
</table>

<p style="color: red">NOTE: Set quantity to 0 to remove item.</p>

<form method="post">
    <button name="action" value="clear">Clear</button>
    <button name="action" value="checkout">Checkout</button>
</form>

<!-- ELSE: Shopping cart EMPTY ------------------------------------------------>
<?php else: ?>

<p class="warning">Your shopping cart is empty.</p>

<?php endif; ?>
<!-- END IF ------------------------------------------------------------------->

<?php
$page->footer();
?>
