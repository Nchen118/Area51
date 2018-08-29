<?php

class Page {

    public $root;
    public $title;
    public $date;
    //security
    public $user;
    public $login_page;
    public $home_page;

    function __construct() {
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->title = 'Untitled';
        $this->date = new DateTime();
        //security
        $this->user = isset($_SESSION['auth_user']) ? $_SESSION['auth_user'] : null;
        $this->home_page = '/';
        $this->login_page = '/account/login.php';
    }

    public function header() {
        include $this->root . '/include/_header.php';
    }

    public function footer() {
        include $this->root . '/include/_footer.php';
    }

    function redirect($url = '') {
        if ($url == '') {
            $url = $_SERVER['REQUEST_URI'];
        }

        ob_clean();
        header("Location: $url");
        exit();
    }

    function is_post() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    function is_get() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function get($name, $default = '', $escape = true, $trim = true) {
        $value = isset($_GET[$name]) ? $_GET[$name] : $default;

        if ($escape)
            $value = htmlspecialchars($value);
        if ($trim)
            $value = trim($value);

        return $value;
    }

    public function post($name, $default = '', $escape = true, $trim = true) {
        $value = isset($_POST[$name]) ? $_POST[$name] : $default;

        if ($escape)
            $value = htmlspecialchars($value);
        if ($trim)
            $value = trim($value);

        return $value;
    }

    public function get_array($name, $default = [], $escape = true, $trim = true) {
        $items = isset($_GET[$name]) ? $_GET[$name] : $default;

        for ($i = 0; $i < count($items); $i++) {
            if ($escape)
                $items[$i] = htmlspecialchars($items[$i]);
            if ($trim)
                $items[$i] = trim($items[$i]);
        }

        return $items;
    }

    public function post_array($name, $default = [], $escape = true, $trim = true) {
        $items = isset($_POST[$name]) ? $_POST[$name] : $default;

        for ($i = 0; $i < count($items); $i++) {
            if ($escape)
                $items[$i] = htmlspecialchars($items[$i]);
            if ($trim)
                $items[$i] = trim($items[$i]);
        }

        return $items;
    }

    public function pdo() {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        return new PDO('mysql:host=localhost;port=3306;dbname=area 51', 'root', '', $options);
    }

    public function temp($key, $value = null) {
        if ($value) {
            if ($key == 'success') {
                $_SESSION["temp_$key"] = "<div class='alert alert-success'>$value</div>";
            } else if ($key == 'warning') {
                $_SESSION["temp_$key"] = "<div class='alert alert-warning'>$value</div>";
            } else {
                $_SESSION["temp_$key"] = $value;
            }
        } else {
            if (isset($_SESSION["temp_$key"])) {
                $value = $_SESSION["temp_$key"];
                unset($_SESSION["temp_$key"]);
                return $value;
            }
        }
    }

    // Security
    public function authorize($roles = '') {
        $arr = explode(',', $roles);

        if ($this->user && $roles == '') {
            // User signed in --> OK
        } else if ($this->user && in_array($this->user->role, $arr)) {
            // User signed in. Role matched --> OK
        } else {
            $return = $_SERVER['REQUEST_URI'];
            $this->redirect($this->login_page . '?return=' . urlencode($return));
        }
    }

    public function unauthorize() {
        if ($this->user) {
            $this->redirect('/');
        }
    }

    public function sign_in($name, $role, $redirect = true) {
        $user = new stdClass();
        $user->name = $name;
        $user->role = $role;
        $user->is_admin = $role == 'admin';
        $user->is_customer = $role == 'customer';

        $_SESSION['auth_user'] = $this->user = $user;

        if ($redirect) {
            $return = $this->get('return');
            if ($return) {
                $this->redirect($return);
            } else {
                $this->redirect($this->home_page);
            }
        }
    }

    public function sign_out($redirect = true) {
        unset($_SESSION['auth_user']);
        $this->user = null;
        global $cart;
        $cart->clear();

        if ($redirect) {
            $this->redirect($this->home_page);
        }
    }

    // TODO: Generate random password
    public function random_password() {
        $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';

        for ($n = 1; $n <= 10; $n++) {
            $i = rand(0, strlen($s) - 1);
            $password .= $s[$i];
        }

        return $password;
    }

    // Email
    public function email($address, $subject, $body, $isHTML = true) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'aacs3173@gmail.com';
        $mail->Password = 'password3173';
        $mail->setFrom('aacs3173@gmail.com', 'Area 51');

        $mail->addAddress($address);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML($isHTML);

        return $mail->send();
    }

    // Check valid webpage
    public function valid_page($page = '') {
        if ($_SERVER['PHP_SELF'] == $page) {
            $this->redirect('/index.php');
        }
    }

}

class html {

    public function text($name, $value = '', $maxlength = '', $attr = '') {
        echo "<input type='text' name='$name' id='$name' value='$value' maxlength='$maxlength' $attr >";
    }

    public function err_msg($err = array(), $type) {
        if (!empty($err)) {
            foreach ($err as $key => $value) {
                if ($key == $type) {
                    echo "<span class='error'>$value</span>";
                }
            }
        }
    }

    public function password($name, $value = '', $maxlength = '', $attr = '') {
        echo "<input type='password' name='$name' id='$name' value='$value' maxlength='$maxlength' $attr>";
    }

    public function focus($name, $err = []) {
        if ($err) {
            $name = array_keys($err)[0];
        }

        echo "<script>$('[name^=$name]').first().focus();</script>";
    }

    public function select($name, $items, $selected = '', $default = true, $attr = '') {
        echo "<select name='$name' id='$name' $attr>";
        if ($default)
            echo '<option value="">-- Select One --</option>';
        foreach ($items as $value => $text) {
            $status = $value == $selected ? 'selected' : '';
            echo "<option value='$value' $status>$text</option>";
        }
        echo '</select>';
    }

    public function hidden($name, $value = '', $attr = '') {
        echo "<input type='hidden' name='$name' id='$name' value='$value' $attr>";
    }

}

class cart {
    // TODO: Restore shopping cart from session variable
    function __construct() {
        $this->items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    // TODO: Set an item (id and quantity)
    public function set($id, $quantity) {
        $n = (int) $quantity;
        if ($n > 0) {
            $this->items[$id] = $n;
        } else {
            $this->remove($id); //remove item if quantity 0
        }
        $_SESSION['cart'] = $this->items;
    }

    // TODO: Get the quantity of an item
    public function get($id) {
        return isset($this->items[$id]) ? $this->items[$id] : 0;
    }

    // TODO: Remove an item
    public function remove($id) {
        unset($this->items[$id]);
        $_SESSION['cart'] = $this->items;
    }

    // TODO: Remove all items
    public function clear() {
        $this->items = [];
        $_SESSION['cart'] = $this->items;
    }

    // TODO: Return all ids (keys)
    public function ids() {
        return array_keys($this->items);
    }

    // TODO: Return items count
    public function count() {
        return count($this->items);
    }

    // TODO: Return total quantity
    public function quantity() {
        return array_sum($this->items);
    }

    // Debug
    public function dump() {
        var_dump($this->items);
    }

}

spl_autoload_register(function($class) {    // spl = standard php library 
    include "include/$class.php";
});

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
ob_start();

$page = new Page();
$html = new Html();
$cart = new cart();

if ($page->user && $page->user->is_customer) {
    $pdo = $page->pdo();
    $stm = $pdo->prepare("SELECT * FROM `cart` WHERE cust_name = ?");
    $stm->execute([$page->user->name]);
    $carts = $stm->fetchAll();

    foreach ($carts as $values) {
        $cart->set($values->prod_id, $values->qty);
    }
}

$page->valid_page('/configLibrary.php');
