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

        <link rel="stylesheet" href="/css/sites.css">
        <script src="/js/site.js"></script>
    </head>
    <body>
        <div class="text-center">
            <header>
                <h1 class="ussr_army">Area 51</h1>
            </header>
            <nav class="d-flex justify-content-between">
                <div class="text-center flex-fill" id="wrap_content">
                    <a href="/index.php" class="nav_space align-middle">Home</a>
                    <a href="#" class="nav_space dropdown align-middle" data-toggle="dropdown">Product</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/product.php?">All</a>
                        <a class="dropdown-item" href="/product.php?category=L">Laptop</a>
                        <a class="dropdown-item" href="/product.php?category=K">Keyboard</a>
                        <a class="dropdown-item" href="/product.php?category=M">Mouse</a>
                        <a class="dropdown-item" href="/product.php?category=H">Headset</a>
                    </div>
                    <a href="/about_us.php" class="nav_space align-middle">About us</a>
                    <a href="#" class="nav_space align-middle">Support</a>
                </div>
                <div class="text-right flex-fill" id="wrap_info">
                    <?php
                    if ($this->user) {
                        if ($this->user->is_customer) {
                            echo "
                                <label>
                                    <img src='{$_SESSION['photo']}' alt='Profile Picture' class='rounded align-middle' width='20px' height='20px'>
                                    <a href='/account/profile_info.php' class='nav_space align-middle'>{$this->user->name}</a>
                                </label>
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
