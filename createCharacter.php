<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

include 'db.php';

// Procesar la creación de un nuevo personaje
if (isset($_POST['add_character'])) {
    $name = $_POST['name'];
    $race = $_POST['race'];
    $avatar = $_POST['avatar'];
    $fuerza = $_POST['fuerza'];
    $velocidad = $_POST['velocidad'];
    $dureza = $_POST['dureza'];

    $user_id = $_SESSION['user_id'];

    // Insertar el nuevo personaje en la base de datos
    $query = $pdo->prepare("
        INSERT INTO characters (user_id, name, race, strength, speed, endurance, level, experience, avatar)
        VALUES (:user_id, :name, :race, :strength, :speed, :endurance, 1, 0, :avatar)
    ");
    $query->execute([
        'user_id' => $user_id,
        'name' => $name,
        'race' => $race,
        'strength' => $fuerza,
        'speed' => $velocidad,
        'endurance' => $dureza,
        'avatar' => $avatar
    ]);

    // Redirigir a la lista de personajes
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
    <title>Crear Personaje</title>
    <style>body{background-image: url(<?php include "functions.php"; echo "./fondo/" . backgroundImg("./fondo");?>);}</style>
    <script src="random.js" defer></script>
</head>
<body>
    <div class="create-character-container">
        <h1>Crear un Nuevo Personaje</h1>
        <form method="POST">
            <?php 
            $user_id = $_SESSION['user_id'];
            $query2 = $pdo->prepare("SELECT * FROM users WHERE id = :id");
            $query2 ->execute(['id' => $user_id]);
            $usuario = $query2->fetch();
            $avatar = $usuario["avatar"];
            $name = getName($avatar);

            ?>
            <label for="name">Nombre del personaje:</label>
            <label for="name" id="name"><?php echo $name; ?></label>
            <input type="text" id="name" name="name" required value=<?php echo $name; ?> hidden>

            <label for="race">Raza:</label>
            <select id="race" name="race">
                <option value="Saiyan">Sayayin</option>
                <option value="Namek">Namek</option>
                <option value="Humano">Humano</option>
                <option value="Freezer Race">Freezer</option>
                <option value="Majin">Majin</option>
            </select>

            <!-- Avatar asignado aleatoriamente -->
            <input type="hidden" id="avatar" name="avatar">
            <div class="avatar-preview" id="avatarPreview"></div>
            <input type="text" hidden name="fuerza" value=<?php echo getfuerza($avatar);?>>
            <input type="text" hidden name="velocidad" value=<?php echo getvelocidad($avatar);?>>
            <input type="text" hidden name="avatar" value=<?php echo $avatar;?>>
            <input type="text" hidden name="dureza" value=<?php echo getdureza($avatar);?>>

            <button type="submit" name="add_character">Agregar Personaje</button>
        </form>
        <form action="dashboardCharacters.php" method="get">
            <button type="submit">Regresar</button>
        </form>
    </div>
</body>
</html>