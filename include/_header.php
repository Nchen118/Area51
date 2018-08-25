
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../img/cb30d-xp4h3.png">
        <link rel="stylesheet" href="../css/sites.css">
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/site.js"></script>
    </head>
    <style>
        img{
            max-width: 100%;
            height:auto;
        }
    </style>
    <body>
        <h1>Area 51</h1>
        <header>  
            <div>
                  <?php
                if ($this->user) {
                    echo "Username = {$this->user->name}<br>";
                    echo "Role = {$this->user->role}";
                    
                    if ($this->user->is_customer) {
                        echo "<img src='/photo/{$_SESSION['photo']}' class='photo'>";
                    }
                }
                ?>
            </div>
            <div id="main_menu">
                <a href="index.php">Home</a>
                <a href="product.php">Product</a>
                <a href="#">About us</a>
                <a href="#">Support</a>
            </div>
          
            <div id="login">
              <?php
            if ($this->user) {
                if ($this->user->is_customer) {
                    echo '<a href="/account/changeProfile.php">Change Profile</a>';    
                }
                echo '<a href="/account/changePassword.php">Change Password</a>';
                echo '<a href="/account/logout.php">Logout</a>';    
            }
            else {
                echo '<a href="/account/register.php">Register</a>';
                echo '<a href="/account/resetPassword.php">Reset Password</a>';
                echo '<a href="/account/login.php">Login</a>';    
            }
            ?>
         
            </div>
        </header>
        
        <main>
            <div>
