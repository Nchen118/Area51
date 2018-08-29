<?php
include 'configLibrary.php';

$email = $firstname = $lastname = $address = $city = $post_code = $state = '';
$total = 0;
$err = [];
$states = array(
    "SL" => "Selangor",
    "KL" => "Wilayah Persekutuan",
    "SW" => "Sarawak",
    "JH" => "Johor",
    "PN" => "Penang",
    "SB" => "Sabah",
    "PR" => "Perak",
    "PH" => "Pahang",
    "NS" => "Negeri Sembilan",
    "KD" => "Kedah",
    "ML" => "Malacca",
    "TR" => "Terengganu",
    "KT" => "Kelantan",
    "PL" => "Perlis"
);
$pdo = $page->pdo();

$ids = $cart->ids();
$in = '(' . str_repeat('?,', count($ids)) . '1)';
$pdo = $page->pdo();
$stm = $pdo->prepare("SELECT * FROM product WHERE id IN $in");
$stm->execute($ids);
$Cart = $stm->fetchAll();

// TODO (2): Calculate total payment
$stm = $pdo->query("SELECT id, price FROM product");
$prices = $stm->fetchAll(PDO::FETCH_KEY_PAIR);

$payment = 0.00;

foreach ($cart->items as $product_id => $quantity) {
    $payment += $quantity * $prices[$product_id];
}

// POST request ----------------------------------------------------------------
if ($page->is_post()) {



    if (!$err) {
        // Everything is OK --> Add order
        // TODO (3): Add order
        $stm = $pdo->prepare("
            INSERT INTO `order` (username, date, payment, card, code, recipient, address)
            VALUES (?, ?, ?, ?, ?, ?, ?) 
        ");
        $stm->execute([$page->user->name, $page->date->format("Y-m-d"), $payment, $card, $code, $recipient, $address]);

        // TODO (4): Add orderlines
        $order_id = $pdo->lastInsertId();
        $stm = $pdo->prepare("
            INSERT INTO orderline (order_id, album_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        foreach ($cart->items as $album_id => $quantity) {
            $stm->execute([$order_id, $album_id, $quantity, $prices[$album_id]]);
        }

        // TODO (5): Clear shopping cart
        $cart->clear();

        $page->temp('success', 'Order added.');
        $page->redirect("/order.php?id=$order_id");
    }
}

$page->title = 'Checkout';
$page->header();
?>
<h2>Checkout Detail</h2>

<form method="post">
    <div class="jumbotron text-body col-8">
        <?php if ($page->user && $page->user->is_customer) { ?>

        <?php } else { ?>
            <div class="wrapper">
                <h3>1. Personal Info</h3>
                <div class="form-group">
                    <label>Email </label>
                    <input type="email" name="email" value="<?= $email ?>" maxlength="50" class="form-control" placeholder="Enter your email address...">
                    <?= $html->err_msg($err, 'email') ?>
                </div>
                <div class="form-group">
                    <label>First Name </label>
                    <input type="text" name="firstname" value="<?= $firstname ?>" maxlength="50" class="form-control" placeholder="Enter your first name...">
                    <?= $html->err_msg($err, 'firstname') ?>
                </div>
                <div class="form-group">
                    <label>Last Name </label>
                    <input type="text" name="lastname" value="<?= $lastname ?>" maxlength="50" class="form-control" placeholder="Enter your last name...">
                    <?= $html->err_msg($err, 'lastname') ?>
                </div>
                <div class="form-group">
                    <label>Address </label>
                    <input type="text" name="address" value="<?= $address ?>" maxlength="50" class="form-control" placeholder="Enter your delivery address...">
                    <?= $html->err_msg($err, 'address') ?>
                </div>
                <div class="form-group">
                    <label>City </label>
                    <input type="text" name="city" value="<?= $city ?>" maxlength="50" class="col-4 form-control" placeholder="Enter your city...">
                    <?= $html->err_msg($err, 'city') ?>
                </div>
                <div class="form-group">
                    <label>Post Code </label>
                    <input type="number" name="post_code" pattern="[0-9]" value="<?= $post_code ?>" maxlength="50" class="col-4 form-control" placeholder="Post code">
                    <?= $html->err_msg($err, 'post_code') ?>
                </div>
                <div class="form-group">
                    <label>State </label>
                    <?= $html->select('state', $states, $state, true, 'class="col-4 form-control"') ?>
                    <?= $html->err_msg($err, 'email') ?>
                </div>
            </div>
            <br><hr class="bg-dark"><br>
            <div class="wrapper">
                <h3>2. Billing Info</h3>
                <div class="form-group">
                    <label>Credit/Debit Card Number</label>
                    <input type="text" name="card_number" inputmode="numeric" maxlength="19" pattern="\d*" class="col-5 form-control cc-number" placeholder="XXXX-XXXX-XXXX-XXXX">
                    <?= $html->err_msg($err, 'card_number') ?>
                </div>
                <div class="form-group">
                    <label>Credit/Debit Card Expire Date</label>
                    <div class="form-inline">
                        <input type="text" name="exp_month" inputmode="numeric" maxlength="2" pattern="\d*" class="col-2 form-control cc-number" placeholder="mm"> / 
                        <input type="text" name="exp_year" inputmode="numeric" maxlength="2" pattern="\d*" class="col-2 form-control cc-number" placeholder="yy">
                        <?= $html->err_msg($err, 'exp') ?>
                    </div>    

                </div>
                <div class="form-group">
                    <label>Credit/Debit Card CVV</label>
                    <input type="text" name="card_cvv" inputmode="numeric" maxlength="3" pattern="\d*" class="col-2 form-control cc-number" placeholder="XXX">
                    <?= $html->err_msg($err, 'card_cvv') ?>
                </div>
            </div>
        <?php } ?>
        <br><hr class="bg-dark"><br>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success form-control">Continue to checkout</button>
            <a href="/" class="back"> Continue Shopping </a>
        </div>
    </div>
    <div class="jumbotron col-4 py-1" id="product_list">
        <h4 class="text-body">3. Referred Checkout</h4>
        <table class="table table-dark table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>QTY</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Cart as $v) {
                    $total += $v->price * $quantity;
                    echo "
                        <tr>
                            <td>$v->name</td>
                            <td>{$cart->get($v->id)}</td>
                        </tr>
                    ";
                }
                ?>
                <tr>
                    <th colspan="2" class="text-right">Total: RM <?= number_format($total, 2) ?></th>
                </tr>
            </tbody>
        </table>
    </div>
</form>
<?php
$html->focus('card', $err);
$page->footer();
?>