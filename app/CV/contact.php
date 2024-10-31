<?php 
session_start();
require 'actions/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
   
   <!-- <link rel="stylesheet" href="assets/styles/navbar.css">-->
    <link rel="stylesheet" href="assets/styles/contact.css">
</head>
<body>
    <div class="contact">
        <div class="map">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d92457.01789476717!2d1.350441622817114!3d43.600673658813356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12aebb6fec7552ff%3A0x406f69c2f411030!2sToulouse!5e0!3m2!1sfr!2sfr!4v1730280139363!5m2!1sfr!2sfr" 
            style="border:0;" allowfullscreen="" loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="form">
            <h1>Contact Us</h1>
            <form action="https://formsubmit.co/bregino2000@gmail.com" method="POST">
                <input type="text" name="name" required placeholder="Name">
                <input type="email" name="email" required placeholder="Email">
                <input type="text" name="subject" required placeholder="Subject">
                <textarea name="message" required placeholder="Message"></textarea>
                <input type="hidden" name="_captcha" value="false">
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    
</body>
</html>