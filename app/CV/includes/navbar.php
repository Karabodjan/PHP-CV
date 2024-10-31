<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="navbar.css"> 
</head>
<body>
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
            <h1 class="logo">CV/ <span>Portofolio.</span></h1>
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="index.php" class="link">Home</a></li>
                <li><a href="#" class="link">About</a></li>
                <li><a href="contact.php" class="link">Contact</a></li>
                <?php if (isset($_SESSION['id'])): ?>
                    <li><a href="perfil.php" class="link">Profile</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="nav-button">
            <?php if (isset($_SESSION['id'])): ?>
                <button class="btn" onclick="window.location.href='logout.php'">Log out</button>
            <?php else: ?>
                <button class="btn white-btn" onclick="window.location.href='login.php'">Sign In</button>
                <button class="btn" onclick="window.location.href='signup.php'">Sign Up</button>
            <?php endif; ?>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>

    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");
            if (i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }
    </script>
</body>
</html>
