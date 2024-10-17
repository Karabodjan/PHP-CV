<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>

<body>
    <form action="authenticate.php" method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Login</button>
    </form>
    
</body>
</html>
