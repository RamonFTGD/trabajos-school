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

if (isset($_GET['enemigo'])) {
    $enemigo = $_GET['enemigo'];
} else {
    $enemigo = "Error";
}

if (isset($_GET['enemifile'])) {
    $enemigofile = $_GET['enemifile'];
} else {
    $enemigofile = "Error";
}

if (isset($_GET['ganador'])) {
    $ganador = $_GET['ganador'];
} else {
    $ganador = "Error";
}

// Función de entrenamiento para aumentar atributos
if (isset($_POST['Torneo'])) {
    elevar($_SESSION['user_id']);
    header('Location: dashboardTournaments.php');
    exit();
}

if (isset($_GET['dañoPj'])) {
    $dañoPj = $_GET['dañoPj'];
} else {
    $dañoPj = "Error";
}

if (isset($_GET['velocidadPj'])) {
    $velocidadPj = $_GET['velocidadPj'];
} else {
    $velocidadPj = "Error";
}

if (isset($_GET['durezaPj'])) {
    $durezaPj = $_GET['durezaPj'];
} else {
    $durezaPj = "Error";
}

if (isset($_GET['dañoEn'])) {
    $dañoEn = $_GET['dañoEn'];
} else {
    $dañoEn = "Error";
}

if (isset($_GET['velocidadEn'])) {
    $velocidadEn = $_GET['velocidadEn'];
} else {
    $velocidadEn = "Error";
}

if (isset($_GET['durezaEn'])) {
    $durezaEn = $_GET['durezaEn'];
} else {
    $durezaEn = "Error";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos.css">
    <style>body{background-image: url(<?php echo "./fondo/" . backgroundImg("./fondo");?>);}</style>
    <title>Resultados</title>
</head>
<body>
<br><br><br>
<div class="dashboard-container">
    <h1>Resultados de la batalla</h1>
    <div class="character-info">
            <img src="./avatar/<?php echo $usuario['avatar']; ?>" alt="Avatar de personaje" width="100">
            <p><strong>Resultados</strong></p>
            <p><strong>Nombre: </strong><?php echo getName($usuario['avatar']); ?></p>
            <p><strong>Daño Total: </strong><?php echo $dañoPj; ?></p>
            <p><strong>Velocidad: </strong><?php echo $velocidadPj; ?></p>
            <p><strong>Dureza: </strong><?php echo $durezaPj ?></p>
        </div>
    </div>
    <div class="dashboard-container">
        <h1 class="vs"> VS </h1>
        <p><strong>Ganador: </strong><?php echo $ganador ?></p>
        <form method="POST">
        <button type="submit" name="Torneo" id="Torneo">Torneo</button>
        </form>
        <p><a href="logout.php">Cerrar Sesión</a></p>  
    </div>
    <div class="dashboard-container">
        <h1>Resultados de la batalla</h1>
        <div class="character-info">
            <img src="./avatar/<?php echo $enemigofile; ?>" alt=<?php echo $enemigofile; ?> width="100">
            <p><strong>Resultados</strong></p>
            <p><strong>Nombre: </strong><?php echo $enemigo; ?></p>
            <p><strong>Daño Total: </strong><?php echo $dañoEn; ?></p>
            <p><strong>Velocidad: </strong><?php echo $velocidadEn; ?></p>
            <p><strong>Dureza: </strong><?php echo $durezaEn ?></p>
        </div>
    </div>
</body>
</html>