<?php
include 'db.php'; //Importar información de un archivo externo
if (isset($_POST['register'])) { //Si doy clic a un boton llamado register+
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $avatar = $_POST['avatar']; // Avatar asignado aleatoriamente

    // Comprobamos si el email ya existe
    $checkEmail = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $checkEmail->execute(['email' => $email]);
    if ($checkEmail->rowCount() > 0) {
        $error = "El correo ya está registrado.";
    } else {
        // Insertamos el nuevo usuario
        $query = $pdo->prepare("INSERT INTO users (name, email, password, avatar) VALUES (:name, :email, :password, :avatar)");
        $query->execute(['name' => $name, 'email' => $email, 'password' => $password, 'avatar' => $avatar]);
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="Estilos.css">
    <style>body{background-image: url(<?php include "functions.php"; echo "./fondo/" . backgroundImg("./fondo");?>);}</style>
</head>
<body>
    <div class="register-container">
        <?php
            $directory = './avatar';
            $files = getFilenames($directory);
            $randomObject = getRandomObject($files);
        ?>
        <h2>Registrarse</h2>
        <?php if (isset($error)):?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" id="avatar" name="avatar" value="<?php echo $randomObject; ?>">
            <div class="avatar-preview" id="avatarPreview">
                <center>
                    <img id="imagenavatar" class="imagenavatar" src="./avatar/<?php echo $randomObject; ?>" alt="" width="150" height="150">
                </center>
            </div>
            <label for="name">Nombre:</label>
            <input type="text" name="name" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="register">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="index.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>