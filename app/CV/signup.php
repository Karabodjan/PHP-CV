<?php
session_start(); // Start the session
$error_message = ''; // Initialize error message

if (isset($_POST['validate'])) {
    // Retrieve and sanitize user inputs
    $pseudo = trim(strip_tags($_POST['pseudo']));
    $lastname = trim(strip_tags($_POST['lastname']));
    $firstname = trim(strip_tags($_POST['firstname']));
    $email = trim(strip_tags($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    // Connect to the database
    $conn = new mysqli('db', 'root', 'root', 'port_db');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the pseudo or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE pseudo = ? OR email = ?");
    $stmt->bind_param("ss", $pseudo, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Error if pseudo or email exists
        $error_message = "Pseudo or email already exists. Please choose another.";
    } else {
        // Insert the user into the database
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (pseudo, lastname, firstname, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $pseudo, $lastname, $firstname, $email, $password);

        if (!$stmt->execute()) {
            $error_message = "Error registering user: " . $stmt->error;
        } else {
            // Redirect to login after successful registration
            header("Location: login.php");
            exit();
        }
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
    <link rel="stylesheet" href="assets/styles/signup.css"> 
    <title>Sign Up</title>
</head>
<body>
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

    <form class="container" method="POST">
    <a href="index.php" style="text-decoration: none;"><h3>Sign Up Here</h3></a>

    <label for="pseudo" class="form-label">Pseudo</label>
    <input type="text" placeholder="Pseudo" name="pseudo" required>
        
    <label for="lastname" class="form-label">Last Name</label>
    <input type="text" placeholder="Last Name" name="lastname" required>
        
    <label for="firstname" class="form-label">First Name</label>
    <input type="text" placeholder="First Name" name="firstname" required>
        
    <label for="email" class="form-label">Email</label>
    <input type="text" placeholder="Email" name="email" required>
    
    <label for="password">Password</label>
    <input type="password" placeholder="Password" name="password" required>
        
    <button type="submit" class="btn btn-primary" name="validate">Subscribe</button>
    <br><br>
    <a href="login.php"><p>I already have an account</p></a>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    </form>
</body>
</html>
