<?php
session_start(); // Start the session
$error_message = ''; // Initialize error message

if (isset($_POST['validate'])) {
    $pseudo = trim(strip_tags($_POST['pseudo']));
    $password = $_POST['password'];

    // Connect to the database
    $conn = new mysqli('db', 'root', 'root', 'port_db');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the query
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE pseudo = ?");
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Successful login
            $_SESSION['id'] = $id;
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/login.css"> 
    <title>Login</title>
</head>
<body>
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<form class="container" method="POST">
<a href="index.php" style="text-decoration: none;"><h3>Login Here</h3></a>
    <label for="pseudo" class="form-label">Pseudo</label>
    <input type="text" placeholder="Email or Phone" name="pseudo" required>

    <label for="password">Password</label>
    <input type="password" placeholder="Password" name="password" required>

    <button type="submit" class="btn btn-primary" name="validate">Log In</button>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <br><br>
    <a href="signup.php"><p>I don't have an account</p></a>
</form>

<?php include 'includes/footer.php';?>

</body>
</html>
