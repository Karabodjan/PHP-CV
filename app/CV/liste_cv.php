<?php
session_start(); // Start the session
require 'actions/db.php'; 

// Retrieve all users with personal info, excluding the admin
$stmt = $pdo->prepare('SELECT id, pseudo, firstname, lastname, email, address, phone, profile_description FROM users WHERE id != :admin_id');
$stmt->execute(['admin_id' => 3]); 
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User CV List</title>
    <link rel="stylesheet" href="assets/styles/liste_cv.css">
</head>
<body>
    <div class="container">
        <h1>User CV List</h1>
        <div class="card-container">
            <?php foreach ($users as $user): ?>
                <div class="card">
                    <h2><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h2>
                    <p><strong>Pseudo:</strong> <?php echo htmlspecialchars($user['pseudo']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($user['profile_description']); ?></p>
                    <?php if (isset($_SESSION['id'])): ?>
                        <a href="cvs/cv_<?php echo htmlspecialchars($user['pseudo']); ?>.php">View CV</a>
                    <?php else: ?>
                        <a href="login.php">View CV</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
