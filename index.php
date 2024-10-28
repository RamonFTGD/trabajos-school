<?php
session_start();
if (isset($_POST['login'])) {
    // Aquí iría la conexión a la base de datos (ejemplo con MySQL)
    include 'db.php'; // Archivo de conexión a la base de datos

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta a la base de datos para verificar el usuario
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->execute(['email' => $email]);
    $user = $query->fetch();

    // Verificación de contraseña    
    if ($user) {
        if($user["password"] == $password){
            $_SESSION['user_id'] = $user['id'];
            $user_id = $_SESSION['user_id'];
            $query = $pdo->prepare("SELECT * FROM characters WHERE user_id = :user_id");
            $query->execute(['user_id' => $user_id]);
            $character = $query->fetch();
            if(!$character){
                header('Location: createCharacter.php');
                exit();
            }else{
                header('Location: dashboard.php');
                exit();
            }
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Torneo de Artes Marciales</title>
    <link rel="stylesheet" href="./Estilos.css">
    <style>body{background-image: url(<?php include "functions.php"; echo "./fondo/" . backgroundImg("./fondo");?>);}</style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta?<a href="register.php">Regístrate aquí</a></p>
    </div>
</body>
</html>