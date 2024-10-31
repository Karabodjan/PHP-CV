<?php
// Check if the session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session
}
require 'actions/db.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Redirect if not logged in
    exit();
}

// Fetch user information from the session ID, excluding admin
$userId = $_SESSION['id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id AND role != "admin"');
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array

// Check if the user was found
if (!$user) {
    die('User not found or access denied.'); // Display error if user not found
}

// Check if the modal form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    // Sanitize and retrieve form data
    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $profileDescription = htmlspecialchars($_POST['profileDescription']);

    // Update user information in the database
    $stmt = $pdo->prepare('UPDATE users SET lastname = :lastname, firstname = :firstname, email = :email, address = :address, phone = :phone, profile_description = :profile_description WHERE id = :id');
    $stmt->execute([
        'lastname' => $lastname,
        'firstname' => $firstname,
        'email' => $email,
        'address' => $address,
        'phone' => $phone,
        'profile_description' => $profileDescription,
        'id' => $userId
    ]);

    // Redirect to the same page to avoid resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
    <link rel="stylesheet" href="assets/styles/perfil.css">
    <link rel="stylesheet" href="assets/styles/navbar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <p><strong>Lastname:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
            <p><strong>Firstname:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Profile Description:</strong> <?php echo htmlspecialchars($user['profile_description']); ?></p>
        </div>
        <button id="editProfileBtn">Edit Information</button>
    </div>

    <!-- Modal for editing information -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Information</h2>
            <form method="POST">
                <input type="hidden" name="update_profile" value="1">
                <label for="lastname">Lastname:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required><br>
                <label for="firstname">Firstname:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br>
                <label for="profileDescription">Profile Description:</label>
                <textarea id="profileDescription" name="profileDescription" required><?php echo htmlspecialchars($user['profile_description']); ?></textarea><br>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Script to open and close the modal
        var modal = document.getElementById("editProfileModal");
        var btn = document.getElementById("editProfileBtn");
        var span = document.getElementsByClassName("close")[0];

        // Open the modal when the button is clicked
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Close the modal when the close button is clicked
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
