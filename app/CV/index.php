<?php
session_start(); 
require 'actions/db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include 'includes/head.php'; ?>
    <link rel="stylesheet" href="assets/styles/index.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
   <div class="welcome-container">
        <p class="welcome-text">Welcome</p>
        <h4 data-text="CV/Portofolio">CV/Portofolio</h4>
</div>
    <div class="home-cta">
        <div class="left">
            <div class="left-container">
                <div class="img-container"><img src="assets/images/curriculum-vitae (1).png" alt="Icone CV"></div>
                <div class="cta-button">
                    <a href="liste_cv.php">CV</a>
                </div>
            </div>
        </div>
        <div class="right">
            <div class="right-container">
                <div class="img-container"><img src="assets/images/portofolio (2).png" alt="Icone portofolio"></div>
                <div class="cta-button">
                    <a href="../portofolio/portofolio.php">Portofolio</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
