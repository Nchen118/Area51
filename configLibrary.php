<?php

class Page {
    public $root;
    public $title;
    public $date;
    
    function __construct() {
        $this->root  = $_SERVER['DOCUMENT_ROOT'];
        $this->title = 'Untitled';
        $this->date  = new DateTime();
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

    public function err_msg($err = array(), $type) {
        if (!empty($err)) {
            foreach ($err as $key => $value) {
                if ($key == $type) {
                    echo "<span class='error'>$value</span>";
                }
            }
        }
    }

    public function pdo() {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        return new PDO('mysql:host=localhost;port=3306;dbname=area51', 'root', '', $options);
    }

}

$page = new Page();
