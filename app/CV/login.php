<?php
session_start(); // Démarrer la session
$error_message = ''; // Initialiser le message d'erreur

if (isset($_POST['validate'])) {
    $pseudo = trim(strip_tags($_POST['pseudo']));
    $password = $_POST['password'];

    // Connexion à la base de données
    $conn = new mysqli('db', 'root', 'root', 'port_db');

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE pseudo = ?");
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $stmt->store_result();

    // Vérifier si l'utilisateur existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password); // Lier l'ID utilisateur et le mot de passe haché
        $stmt->fetch();

        // Vérifier le mot de passe
        if (password_verify($password, $hashed_password)) {
            // Connexion réussie
            $_SESSION['user_id'] = $user_id; // Stocker l'ID utilisateur dans la session
            header("Location: index.php"); // Rediriger vers index.php
            exit(); // Assurez-vous d'appeler exit après header
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
    <link rel="stylesheet" href="login.css"> 
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
</body>
</html>
