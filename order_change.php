<?php
include 'configLibrary.php';
$page->authorize('admin');
$err = array();
$pdo = $page->pdo();

// POST request (update) -------------------------------------------------------
if ($page->is_post()) {
    $id = $page->get('id');
    $personal_detail = $page->post('personal_detail');
    $transaction_id = $page->post('transaction_id');
    $product_id = $page->post('product_id');
    $delivery_note = $page->post('delivery_note');
    $delivery_time = $page->post('delivery_time');
    $delivery_day = $page->post('delivery_day');
    $created = $page->post('created');
    $quantity = $page->post('quantity');

    if ($delivery_note == '') {
        $err['delivery_notes'] = 'Delivery Note is required.';
    }
    if ($delivery_day == '') {
        $err['delivery_day'] = 'Date required.';
    } else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $delivery_day)) {
        $err['delivery_day'] = 'Date format Invalid';
    }

    if ($delivery_time == '') {
        $err['delivery_time'] = 'Delivery Time is required';
    }
    else if (!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $delivery_time)) {
        $err['delivery_time'] = 'Delivery Time wrong format';
    }
    
    if (!$err) {
        // (1) Update member record
        $stm = $pdo->prepare("
            UPDATE `order`
            SET delivery_notes = ?, delivery_time = ?, delivery_day = ?, created = ?, quantity = ?
            WHERE id = ?
        ");
        $stm->execute([$delivery_note, $delivery_time, $delivery_day, $created, $quantity, $id]);

        $page->temp('success', 'Order changed.');
        $page->redirect('/index.php');
    }
}

if ($page->is_get()) {
    $id = $page->get('id');
    if (!$id) {
        $page->redirect('/view_product.php');
    }
    $stm = $pdo->prepare("SELECT * FROM `order` WHERE id = ?");
    $stm->execute([$id]);
    $m = $stm->fetch();

    $personal_detail = $m->personal_detail;
    $transaction_id = $m->transaction_id;
    $product_id = $m->product_id;
    $delivery_note = $m->delivery_notes;
    $delivery_time = $m->delivery_time;
    $delivery_day = $m->delivery_day;
    $created = $m->created;
    $quantity = $m->quantity;
    if($m==null){
        $page->redirect('order_history.php');
    }
}

$page->title = 'Change Order Detail';
$page->header();
?>
<?= $page->temp('success') ?>
<h2>Order Detail</h2>
<form method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="jumbotron text-body">
        <div class="row form-group">
            <div class="col-3 text-right">Personal Detail</div>
            <strong><?= $personal_detail ?></strong>
            <input type="hidden" name="personal_detail" value="<?= $personal_detail ?>">
        </div>        
        <div class="row form-group">
            <div class="col-3 text-right">Transaction Id</div>
            <strong><?= $transaction_id ?></strong>
            <input type="hidden" name="transaction_id" value="<?= $transaction_id ?>">
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Product Id</div>
            <strong><?= $product_id ?></strong>
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Delivery Notes</div>
            <?php $html->text('delivery_note', $delivery_note, 100, 'class="col-8 text-left form-control"') ?>
            <?php $html->err_msg($err, 'delivery_note') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Delivery Time</div>
            <input type="time" name="delivery_time" value="<?= $delivery_time ?>" class="col-4 form-control">
            <?php $html->err_msg($err, 'delivery_time') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right"placeholder="YYYY-MM-dd" >Delivery Date</div>
            <input type="date" name="delivery_day" value="<?= $delivery_day ?>" class="col-4 form-control">
            <?php $html->err_msg($err, 'delivery_day') ?>
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Created</div>
            <strong><?= $created ?></strong>
            <input type="hidden" name="created" value="<?= $created ?>">
        </div>
        <div class="row form-group">
            <div class="col-3 text-right">Quantity</div>
            <?php $html->select('quantity', range(0, 10), $quantity, false, 'class="col-2 text-left form-control"') ?>
            <?php $html->err_msg($err, 'quantity') ?>
        </div>

        <div class="text-center">
            <a href="javascript:history.back()" class="btn btn back">Back</a>
            <button type="submit" class="btn btn-primary">Change Profile</button>
        </div>
    </div>
</form>
<?php
$page->footer();
?>

