<?php
include 'configLibrary.php';
$page->authorize('admin');

$err = [];
$code = $page->random_code();
if ($page->is_post()) {
    $code = $page->post('code');
    $rate = $page->post('rate');
    
    if ($code == '') {
        $err['code'] = 'Discount code is empty';
    }
    else if (strlen($code) != 6) {
        $err['code'] = 'Discount code must be 6 characters';
    }
    
    if ($rate == '') {
        $err['rate'] = 'Discount rate is empty';
    }
    else if (!filter_var($rate, FILTER_VALIDATE_INT)) {
        $err['rate'] = 'Discount rate is not number';
    }
    else if (strlen($rate) > 3 || $rate < 0 || $rate > 100) {
        $err['rate'] = 'Discount rate not match';
    }
    
    if (!$err) {
        $pdo = $page->pdo();
        $stm = $pdo->prepare("INSERT INTO `discount`(`discount_code`, `rate`) VALUES (?, ?)");
        $stm->execute([$code, $rate]);
        $page->temp('success', 'Successfully added');
    }
}

$page->title = 'Discount Code';
$page->header();
?>
<?= $page->temp('success') ?>
<h2>Discount Code</h2>
<form method="post" autocomplete="off">
    <div class="jumbotron text-body wrapper">
        <br>
        <div class="form-group row">
            <label>Code: </label>
            <input type="text" name="code" value="<?= $code ?>" maxlength="6" placeholder="6 Characters" class="col-2 form-control">
            <?= $html->err_msg($err, 'code') ?>
        </div>
        <div class="form-group row">
            <label>Discount Rate: </label>
            <input type="number" name="rate" value="<?= $rate ?>" max="100" min="0" placeholder="%" class="col-2 form-control">
            <?= $html->err_msg($err, 'rate') ?>
        </div>
        <div class="form-group">
            <a href="/" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
        <br>
    </div>
</form>
<?php
$page->footer();
?>
