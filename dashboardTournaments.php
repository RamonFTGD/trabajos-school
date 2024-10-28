<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

include 'db.php';
include "functions.php";
$character = selectPj($_SESSION['user_id']);
$usuario = selectUser($_SESSION['user_id']);


if (!$character) {
    echo "No tienes ningún personaje creado.";
    exit();
}

// Función de entrenamiento para aumentar atributos
if (isset($_POST['Entrenar'])) {
    elevar($_SESSION['user_id']);
    header('Location: dashboardTournaments.php');
    exit();
}

if (isset($_POST['regresar'])) {
    header('Location: dashboard.php');
    exit();
}

if (isset($_POST['Ataque'])) {
    $resultados = Ataques($_SESSION["user_id"]);
    ganador($resultados['ganador'], $_SESSION["user_id"]);
    header('Location: results.php?id=' . $_SESSION['user_id'] . '&dañoPj='.$resultados["dañoPj"]. "&enemifile=".$resultados['enemyfile']."&velocidadPj=".$resultados['velocidadPj']."&durezaPj=".$resultados['durezaPj']."&enemigo=".$resultados['enemigo']."&ganador=".$resultados['ganador']."&dañoEn=".$resultados["dañoEn"]."&velocidadEn=".$resultados['velocidadEn']."&durezaEn=".$resultados['durezaEn']);
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
    <title>Dashboard - Torneo de Artes Marciales</title>
</head>
<body>
    <div class="dashboard-container">
        <h1>Bienvenido al Torneo de Artes Marciales</h1>
        <h2>Tu personaje</h2>

        <!-- Mostrar los detalles del personaje -->
        <div class="character-info">
            <img src="avatar/<?php echo $usuario['avatar']; ?>" alt="Avatar de personaje" width="100">
            <p><strong>Nombre:</strong> <?php echo $character['name']; ?></p>
            <p><strong>Raza:</strong> <?php echo $character['race']; ?></p>
            <p><strong>Experiencia:</strong> <?php echo $character['experience']; ?></p>
            <p><strong>LevelUp:</strong> <?php echo ($character['level'] * 10) - $character['experience']; ?></p>
            <p><strong>Nivel:</strong> <?php echo $character['level']; ?></p>
            <p><strong>Fuerza:</strong> <?php echo $character['strength']; ?></p>
            <p><strong>Velocidad:</strong> <?php echo $character['speed']; ?></p>
            <p><strong>Resistencia:</strong> <?php echo $character['endurance']; ?></p>
        </div>

        <!-- Botón para entrenar el personaje -->
        <form method="POST">
            <button type="submit" name="Entrenar" id="Entrenar">Entrenar</button>
            <button type="submit" name="Ataque" id="Ataque">Atacar Jugadores</button>
            <button type="submit" name="regresar" id="regresar">Regresar</button>
        </form>

        <!-- Cerrar sesión -->
        <p><a href="logout.php">Cerrar Sesión</a></p>
    </div>
</body>
</html>