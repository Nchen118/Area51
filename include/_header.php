
<html lang="en">
    <head>
        <title><?= $this->title ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../img/cb30d-xp4h3.png">

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
    <style>
        img{
            max-width: 100%;
            height:auto;
        }
    </style>
    <body>
        <div class="text-center">
            <header>
                <h1 class="ussr_army">Area 51</h1>
            </header>
            <nav>
                <div class="text-center" id="wrap_content">
                    <?php
                    if ($this->user) {
                        echo "Username = {$this->user->name}<br>";
                        echo "Role = {$this->user->role}";

                        if ($this->user->is_customer) {
                            echo "<img src='/photo/{$_SESSION['photo']}' class='photo'>";
                        }
                    }
                    ?>
                    <a href="/index.php" class="nav_space">Home</a>
                    <a href="#" class="nav_space dropdown" data-toggle="dropdown">Product</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/product.php?">All</a>
                        <a class="dropdown-item" href="/product.php?category=L">Laptop</a>
                        <a class="dropdown-item" href="/product.php?category=K">Keyboard</a>
                        <a class="dropdown-item" href="/product.php?category=M">Mouse</a>
                        <a class="dropdown-item" href="/product.php?category=H">Headset</a>
                    </div>
                    <a href="/about_us.php" class="nav_space">About us</a>
                    <a href="#" class="nav_space">Support</a>
                </div>
                <div class="text-right" id="wrap_info">
                    <?php
                    if ($this->user) {
                        if ($this->user->is_customer) {
                            echo '<a href="/account/changeProfile.php" class="nav_space">Change Profile</a>';
                        }
                        echo '<a href="/account/logout.php" class="nav_space">Logout</a>';
                    } else {
                        echo '<a href="/account/login.php" class="nav_space">Login</a>';
                        echo '<a href="/account/register.php" class="nav_space">Register</a>';
                    }
                    ?>
                </div>
            </nav>
        </div>
        <main>
            <div class="container">
