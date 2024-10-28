<?php
include 'db.php';

// Obtener los personajes y su número de torneos ganados
$query = $pdo->query("
    SELECT characters.name, characters.race, characters.ganar, COUNT(characters.id) AS wins 
    FROM characters 
    GROUP BY characters.id
    ORDER BY wins DESC, characters.level DESC
");
$characters = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos.css">
    <title>Tabla de Clasificación</title>
    <style>body{background-image: url(<?php include "functions.php"; echo "./fondo/" . backgroundImg("./fondo");?>);}</style>
</head>
<body>
    <div class="leaderboard-container">
        <h1>Tabla de Clasificación</h1>
        <table>
            <thead>
                <tr>
                    <th>Personaje</th>
                    <th>Raza</th>
                    <th>Torneos Ganados</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($characters as $character): ?>
                    <tr>
                        <td><?php echo $character['name']; ?></td>
                        <td><?php echo $character['race']; ?></td>
                        <td><?php echo $character['ganar']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Botón para regresar al dashboard principal -->
        <form action="dashboard.php" method="get">
            <button type="submit">Regresar</button>
        </form>
    </div>
</body>
</html>