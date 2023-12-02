<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtZoro Presentation Website</title>
    <link rel="stylesheet" href="style1.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="main-header">

        <nav class="main-nav">
            <div class="navigation-container">
                <div class="logo-container"><a href="webpage.php"><img class="logo" src="./img/LOGOBlack.png" alt="logo white"></a></div>
                <ul class="menu-main">
                    <li><a href="webpage.php">HOME</a></li>
                    <li><a href="about.php">ABOUT</a></li>
                    <li><a href="map.php">MAP</a></li>
                    <li><a href="walls.php">WALLS</a></li>
                    <li><a href="community.php">COMMUNITY</a></li>
                    <li><a href="shops.php">SHOPS</a></li>
                    <li><a href="contact.php">CONTACT</a></li>
                </ul>
            </div>
            <ul class="menu-member">
                <?php
                if (isset($_SESSION["userid"])) {
                ?>
                    <li><a href="profile.php"><?php echo $_SESSION["username"]; ?></a></li>
                    <li><a href="includes/logout.inc.php" class="header-login-a">LOGOUT</a></li>
                <?php
                } else {
                ?>
                    <li><a href="indexsignup.php">SIGN UP</a></li>
                    <li><a href="indexlogin.php" class="header-login-a ">LOGIN</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>