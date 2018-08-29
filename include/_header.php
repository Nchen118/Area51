<html lang="en">
    <head>
        <title><?= $this->title ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../img/icon.png">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

        <!-- Google icon's -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <link rel="stylesheet" href="/css/sites.css">
        <script src="/js/site.js"></script>
    </head>
    <body>
        <div class="text-center">
            <header>
                <h1 class="ussr_army">Area 51</h1>
            </header>
            <nav class="d-flex justify-content-between sticky-top">
                <div class="text-center flex-fill" id="wrap_content">
                    <a href="/index.php" class="nav_space align-middle">Home</a>
                    <a href="" class="nav_space dropdown align-middle" data-toggle="dropdown">Product</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/product.php?">All</a>
                        <a class="dropdown-item" href="/product.php?category=LP">Laptop</a>
                        <a class="dropdown-item" href="/product.php?category=KB">Keyboard</a>
                        <a class="dropdown-item" href="/product.php?category=MS">Mouse</a>
                        <a class="dropdown-item" href="/product.php?category=HS">Headset</a>
                    </div>
                    <a href="/about_us.php" class="nav_space align-middle">About us</a>
                    <a href="/support.php" class="nav_space align-middle">Support</a>
                </div>
                <div class="text-right flex-fill" id="wrap_info">
                    <span id="cart">
                        <a href="/cart.php" class="material-icons text-light align-middle">shopping_cart</a>
                        <?php
                        global $cart;
                        if ($cart->count()) {
                            echo "<span class='badge badge-light'>{$cart->count()}</span>";
                        }
                        ?>
                    </span>
                    <?php
                    if ($this->user) {
                        if ($this->user->is_customer) {
                            echo "
                                <img src='/picture/{$_SESSION['photo']}' alt='Profile Picture' class='rounded-circle' width='30px' height='30px'>
                                <a href='' class='nav_space dropdown align-middle' data-toggle='dropdown'>{$this->user->name}</a>
                                <div class='dropdown-menu'>
                                    <a class='dropdown-item' href='/account/profile_info.php'>Edit profile</a>
                                    <a class='dropdown-item' href='/account/change_password.php'>Change password</a>
                                </div>
                            ";
                        }
                        if ($this->user->is_admin) {
                            echo "
                                <a href='' class='nav_space dropdown align-middle' data-toggle='dropdown'>Admin</a>
                                <div class='dropdown-menu'>
                                    <a class='dropdown-item' href='/addproduct.php'>Add product</a>
                                    <a class='dropdown-item' href='/view_product.php'>View product</a>
                                    <a class='dropdown-item' href='/view_customer.php'>View customer</a>
                                    <a class='dropdown-item' href='/restore_database.php'>Restore database</a>
                                    <a class='dropdown-item' href='/account/change_password.php'>Change password</a>
                                </div>
                            ";
                        }
                        echo '<a href="/account/logout.php" class="nav_space align-middle">Logout</a>';
                    } else {
                        echo '<a href="/account/login.php" class="nav_space align-middle">Login</a>';
                        echo '<a href="/account/register.php" class="nav_space align-middle">Register</a>';
                    }
                    ?>
                </div>
            </nav>
        </div>
        <main>
            <div class="container">
