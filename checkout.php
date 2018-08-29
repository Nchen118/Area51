<?php
include 'configLibrary.php';

$email = $firstname = $lastname = $address = $city = $post_code = $state = '';
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
if (!$ids) {
    $page->redirect("/");
}
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

if ($page->user && $page->user->is_customer) {
    $stm = $pdo->prepare("SELECT * FROM `customer` WHERE username = ?");
    $stm->execute([$page->user->name]);
    $user = $stm->fetch();

    $email = $user->email;
    $firstname = $user->first_name;
    $lastname = $user->last_name;
    $address = $user->address;
    $city = $user->city;
    $post_code = $user->post_code;
    $state = $user->state;
}

// POST request ----------------------------------------------------------------
if ($page->is_post()) {

    // Personal info
    $email = $page->post('email');
    $firstname = $page->post('firstname');
    $lastname = $page->post('lastname');
    $address = $page->post('address');
    $city = $page->post('city');
    $post_code = $page->post('post_code');
    $state = $page->post('state');
    
    // Credit/Debit Card info
    $card_number = $page->post('card_number');
    $card_exp = $page->post('exp_month') . "/" . $page->post('exp_year');
    $card_exp_month = $page->post('exp_month');
    $card_exp_year = $page->post('exp_year');
    $card_cvv = $page->post('card_cvv');
    
    // Personal info Validation
    if ($email == "") {
        $err['Email'] = 'Email is empty';
    } else if (strlen($email) > 30) {
        $err['Email'] = 'Email can not more than 30 characters';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err['Email'] = 'Invalid email format';
    }
    
    if ($firstname == '') {
        $err['firstname'] = 'First Name is empty.';
    }
    else if (strlen($firstname) > 50) {
        $err['firstname'] = 'First Name must not more than 50 characters.';
    }
    
    if ($lastname == '') {
        $err['lastname'] = 'Last Name is empty.';
    }
    else if (strlen($lastname) > 50) {
        $err['lastname'] = 'Last Name must not more than 50 characters.';
    }
    
    if ($address == '') {
        $err['address'] = 'Address is empty.';
    }
    else if (strlen($address) > 100) {
        $err['address'] = 'Address must not more than 100 characters.';
    }
    
    if ($city == '') {
        $err['city'] = 'City is empty.';
    }
    else if (strlen($city) > 30) {
        $err['city'] = 'City must not more than 30 characters.';
    }
    
    if ($post_code == '') {
        $err['post_code'] = 'Post code is empty.';
    }
    else if (!preg_match("/^\d{5}$/", $post_code)) {
        $err['post_code'] = 'Please enter 5 number only.';
    }
    
    if ($state == '') {
        $err['state'] = 'State is empty.';
    }
    else if (in_array($state, $states)) {
        $err['state'] = 'Choose a valid state.';
    }
    
    // Card Validation
    if ($card_number == '') {
        $err['card_number'] = 'Card number is empty.';
    }
    else if (strlen($card_number) > 19 || !preg_match("/^\d{4}-\d{4}-\d{4}-\d{4}$/", $card_number)) {
        $err['card_number'] = 'Card number wrong format.';
    }
    
    if ($card_exp == '') {
        $err['exp'] = 'Card expire date is empty.';
    }
    else if (strlen($card_exp) > 5 || !preg_match("/^\d{2}\\/\d{2}$/", $card_exp)) {
        $err['exp'] = 'Card expire date wrong format.';
    }
    else if ($card_exp_month < 1 || $card_exp_month > 12) {
        $err['exp'] = 'Card expire date wrong format.';
    }
    
    if ($card_cvv == '') {
        $err['card_cvv'] = 'Card CVV is empty.';
    } 
    else if (strlen($card_cvv) > 3 || !preg_match("/^\d{3}$/", $card_cvv)) {
        $err['card_cvv'] = 'Card CVV wrong format.';
    }
    
    if (!$err) {
        // Insert personal info
        $stm = $pdo->prepare("INSERT INTO `personal_detail`(`email`, `firstname`, `lastname`, `address`, `city`, `post_code`, `state`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stm->execute([$email, $firstname, $lastname, $address, $city, $post_code, $state]);
        
        $stm = $pdo->query("SELECT id FROM `personal_detail` ORDER BY `id` DESC LIMIT 1");
        $personal_detail = $stm->fetchColumn();
        
        // Insert transaction info
        $stm = $pdo->prepare("INSERT INTO `transaction`(`total`, `card_number`, `exp_date`, `cvv`, `payment_date`) VALUES (?, ?, ?, ?, ?)");
        $stm->execute([$payment, $card_number, $card_exp, $card_cvv, $page->date->format("Y-m-d")]);
        
        $stm = $pdo->query("SELECT id FROM `transaction` ORDER BY `id` DESC LIMIT 1");
        $transaction_id = $stm->fetchColumn();
        
        // Insert order info
        foreach ($cart->items as $product_id => $quantity) {
            $stm = $pdo->prepare("INSERT INTO `order`(`personal_detail`, `transaction_id`, `product_id`, `quantity`) VALUES (?, ?, ?, ?)");
            $stm->execute([$personal_detail, $transaction_id, $product_id, $quantity]);
        }

        // TODO (5): Clear shopping cart
        if ($page->user && $page->user->is_customer) {
            $stm = $pdo->prepare("DELETE FROM `cart` WHERE cust_name = ?");
            $stm->execute([$page->user->name]);
        }
        $cart->clear();

        $page->temp('success', 'Order added.');
        $page->redirect("/");
    }
}

$page->title = 'Checkout';
$page->header();
?>
<h2>Checkout Detail</h2>

<form method="post" autocomplete="off">
    <div class="jumbotron text-body col-8">
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
                <input type="number" name="post_code" value="<?= $post_code ?>" maxlength="50" class="col-4 form-control" placeholder="Post code" inputmode="numeric">
                <?= $html->err_msg($err, 'post_code') ?>
            </div>
            <div class="form-group">
                <label>State </label>
                <?= $html->select('state', $states, $state, true, 'class="col-4 form-control"') ?>
                <?= $html->err_msg($err, 'state') ?>
            </div>
        </div>
        <br><hr class="bg-dark"><br>
        <div class="wrapper">
            <h3>2. Billing Info</h3>
            <div class="form-group">
                <label>Credit/Debit Card Number</label>
                <input type="text" name="card_number" inputmode="numeric" maxlength="19" pattern="\d{4}-\d{4}-\d{4}-\d{4}" class="col-5 form-control cc-number" placeholder="XXXX-XXXX-XXXX-XXXX">
                <?= $html->err_msg($err, 'card_number') ?>
            </div>
            <div class="form-group">
                <label>Credit/Debit Card Expire Date</label>
                <div class="form-inline">
                    <input type="text" name="exp_month" inputmode="numeric" maxlength="2" pattern="\d{2}" class="col-2 form-control cc-number" placeholder="mm"> / 
                    <input type="text" name="exp_year" inputmode="numeric" maxlength="2" pattern="\d{2}" class="col-2 form-control cc-number" placeholder="yy">
                    <?= $html->err_msg($err, 'exp') ?>
                </div>    

            </div>
            <div class="form-group">
                <label>Credit/Debit Card CVV</label>
                <input type="text" name="card_cvv" inputmode="numeric" maxlength="3" pattern="\d{3}" class="col-2 form-control cc-number" placeholder="XXX">
                <?= $html->err_msg($err, 'card_cvv') ?>
            </div>
        </div>
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
                    echo "
                        <tr>
                            <td>$v->name</td>
                            <td>{$cart->get($v->id)}</td>
                        </tr>
                    ";
                }
                ?>
                <tr>
                    <th colspan="2" class="text-right">Total: RM <?= number_format($payment, 2) ?></th>
                </tr>
            </tbody>
        </table>
    </div>
</form>
<?php
$html->focus('card', $err);
$page->footer();
?>