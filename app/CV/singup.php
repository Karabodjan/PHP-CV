<?php
if (isset($_POST['validate'])) {
    $pseudo = trim(strip_tags($_POST['pseudo']));
    $lastname = trim(strip_tags($_POST['lastname']));
    $firstname = trim(strip_tags($_POST['firstname']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografar a senha

    // Conectar ao banco de dados
    $conn = new mysqli('db', 'root', 'root', 'port_db'); // Altere para 'port_db'


    // Verificar a conexão
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Inserir o usuário no banco de dados
    $stmt = $conn->prepare("INSERT INTO users (pseudo, lastname, firstname, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $pseudo, $lastname, $firstname, $password);

    if (!$stmt->execute()) {
        echo "Erro ao registrar usuário: " . $stmt->error;
    } else {
        echo "Usuário registrado com sucesso!";
        // Redirecionar ou outra ação
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="login_singup.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <br><br>
<form class="container" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Pseudo</label>
    <input type="text" class="form-control" name="pseudo">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nom</label>
    <input type="text" class="form-control"name="lastname">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Prénom</label>
    <input type="text" class="form-control"name="firstname">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  <button type="submit" class="btn btn-primary"name="validate">S'inscrire</button>
</form>
        </body>
</html>
