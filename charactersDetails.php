<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

include 'db.php';
include "functions.php";

$character = selectPj($_SESSION["user_id"]);
if (!$character['avatar']){
    echo "Personaje no encontrado.";
    exit();
}

if (isset($_POST['train'])) {
    header("Location: dashboardTournaments.php?id=$character_id");
    exit();
}

if (isset($_POST['delete'])) {
    $query = $pdo->prepare("DELETE FROM characters WHERE id = :character_id AND user_id = :user_id");
    $query->execute(['character_id' => $character_id, 'user_id' => $_SESSION['user_id']]);
    header('Location: listCharacters.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos.css">
    <style>body{background-image: url(<?php echo "./fondo/" . backgroundImg("./fondo");?>);}</style>
    <title>Detalles del Personaje</title>
</head>
<body>
    <div class="character-details-container">
        <h1>Detalles del Personaje</h1>
        <div class="avatar-preview" id="avatarPreview">
            <center>
                <img id="imagenavatar" class="imagenavatar" src="avatar/<?php echo $character['avatar']; ?>" alt="Avatar de personaje" width="200" height="200">
            </center>
        </div>
        <p><strong>Nombre:</strong> <?php echo $character['name']; ?></p>
        <p><strong>Raza:</strong> <?php echo $character['race']; ?></p>
        <p><strong>Nivel:</strong> <?php echo $character['level']; ?></p>
        <p><strong>Fuerza:</strong> <?php echo $character['strength']; ?></p>
        <p><strong>Velocidad:</strong> <?php echo $character['speed']; ?></p>
        <p><strong>Resistencia:</strong> <?php echo $character['endurance']; ?></p>

        <form method="POST" style="display:inline;">
            <button type="submit" name="train" >Entrenar Personaje</button>
        </form>

        <form method="POST" style="display:inline;">
            <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este personaje?');">Eliminar Personaje</button>
        </form>

        <form action="listCharacters.php" method="get">
            <button type="submit">Regresar a la Lista de Personajes</button>
        </form>
    </div>
</body>
</html>