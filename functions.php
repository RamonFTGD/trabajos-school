<?php
    function getvelocidad($file){
        switch ($file) {
            case "Avatar1.png":
                return 5000000;
            case "Avatar2.png":
                return 9000000;
            case "Avatar3.png":
                return 8500000;
            case "Avatar4.png":
                return 10000000;
            case "Avatar5.png":
                return 11000000;
            case "Avatar6.png":
                return 8500000;
            case "Avatar7.png":
                return 8000000;
            case "Avatar8.png":
                return 7800000;
            case "Avatar9.png":
                return 9500000;
            case "Avatar10.png":
                return 7000000;
            case "Avatar11.png":
                return 6000000;
            default:
                return 9000000;
        }
    }

    function getdureza($file){
        switch ($file) {
            case "Avatar1.png":
                return 8500;
            case "Avatar2.png":
                return 9000;
            case "Avatar3.png":
                return 9500;
            case "Avatar4.png":
                return 9999;
            case "Avatar5.png":
                return 10000;
            case "Avatar6.png":
                return 9000;
            case "Avatar7.png":
                return 8500;
            case "Avatar8.png":
                return 9000;
            case "Avatar9.png":
                return 10000;
            case "Avatar10.png":
                return 9500;
            case "Avatar11.png":
                return 9000;
            default:
                return 9500;
        }
    }
    function getfuerza($file){
        switch ($file) {
            case "Avatar1.png":
                return 1500000;
            case "Avatar2.png":
                return 3000000;
            case "Avatar3.png":
                return 2800000;
            case "Avatar4.png":
                return 10000000;
            case "Avatar5.png":
                return 12000000;
            case "Avatar6.png":
                return 3000000;
            case "Avatar7.png":
                return 1800000;
            case "Avatar8.png":
                return 3000000;
            case "Avatar9.png":
                return 8000000;
            case "Avatar10.png":
                return 6000000;
            case "Avatar11.png":
                return 4000000;
            default:
                return 7000000;
        }
    }
    function getName($file){
        switch ($file) {
            case "Avatar1.png":
                return "Cumber";
            case "Avatar2.png":
                return "Goku";
            case "Avatar3.png":
                return "Broly";
            case "Avatar4.png":
                return "Bills";
            case "Avatar5.png":
                return "Wiss";
            case "Avatar6.png":
                return "Vegeta";
            case "Avatar7.png":
                return "Trunks";
            case "Avatar8.png":
                return "Goku Black";
            case "Avatar9.png":
                return "Jiren";
            case "Avatar10.png":
                return "Toppo";
            case "Avatar11.png":
                return "Frezzer";
            default:
                return "Hit";
        }
    }
    function getFilenames($directory) {
        $files = array_diff(scandir($directory), array('.', '..'));
        return $files;
    }
    function getRandomObject($files) {
        $randomIndex = array_rand($files);
        return $files[$randomIndex];
    }

    function elevar($user_id){
        include "db.php";
        $experiencia = rand(1, 10);
        $query = $pdo->prepare("
            UPDATE characters 
            SET experience = experience + :experience
            WHERE user_id = :user_id
        ");
        $query->execute([
            'experience' => $experiencia,
            'user_id' => $user_id
        ]);
        $query2 = $pdo->prepare("SELECT * FROM characters WHERE user_id = :user_id");
        $query2 ->execute(['user_id' => $user_id]);
        $character = $query2->fetch();
        if($character["experience"] > ($character["level"] * 10)){
            $query = $pdo->prepare("
            UPDATE characters 
            SET experience = :experience, level = level + :level, strength = strength + :strength, speed = speed + :speed
            WHERE user_id = :user_id
            ");
            $daño = $character['strength'] * 0.01;
            $velocidad = $character['strength'] * 0.01;
            $query->execute([
                'experience' => 0,
                'level' => 1,
                'strength' => $daño,
                'speed' => $velocidad,
                'user_id' => $user_id
            ]);
        }
    }

    function ganador($mensaje, $user_id){
        if($mensaje === getName(selectPj($user_id)['avatar'])){
            include "db.php";
            $query = $pdo->prepare("
                UPDATE characters 
                SET ganar = ganar + 1
                WHERE user_id = :user_id
            ");
            $query->execute([
                'user_id' => $user_id
            ]);
        }
    }

    function selectPj($user_id){
        include "db.php";
        $query = $pdo->prepare("SELECT * FROM characters WHERE user_id = :user_id");
        $query->execute(['user_id' => $user_id]);
        return $query->fetch();
    }

    function selectUser($user_id){
        include "db.php";
        $query2 = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $query2 ->execute(['id' => $user_id]);
        return $query2->fetch();
    }

    function Ataques($user_id){
        //Personaje
        $personaje = selectPj($user_id);
        //Aleatorio
        $files = getFilenames("./avatar");
        $aleatorio = getRandomObject($files);
        //Usuario
        $fuerzaPj = getfuerza($personaje['avatar']);
        $durezaPj = getdureza($personaje['avatar']);
        $velocidadPj = getvelocidad($personaje['avatar']);
        //Enemigo
        $ganador = "";
        $fuerzaEn = getfuerza($aleatorio);
        $durezaEn = getdureza($aleatorio);
        $velocidadEn = getvelocidad($aleatorio);
        //Aqui totdo el funcionamiento
        $fuerzaPj1 = rand(1000, $fuerzaPj);
        $durezaPj1 = rand(1000, $durezaPj);
        $velocidadPj1 = rand(1000, $velocidadPj);
        $fuerzaEn1 = rand(10000, $fuerzaEn);
        $durezaEn1 = rand(10000, $durezaEn);
        $velocidadEn1 = rand(10000, $velocidadEn);
        $nombrePj = getName($personaje['avatar']);
        $nombreEn = getName($aleatorio);
        if($velocidadPj1 > $velocidadEn1){
            if($fuerzaPj1 > $fuerzaEn1){
                if($fuerzaPj1 > $durezaEn1){
                    $ganador = $nombrePj;
                }else{
                    $ganador = "Empate";
                }
            }else if($fuerzaPj1 < $fuerzaEn1){
                if($fuerzaEn1 > $durezaPj1){
                    $ganador = $nombreEn;
                }else{
                    $ganador = $nombrePj;
                }
            }else{
                if($fuerzaPj1 > $durezaEn1){
                    $ganador = $nombrePj;
                }else{
                    $ganador = $nombreEn;
                }
            }
        }else if($velocidadPj1 < $velocidadEn1){
            if($fuerzaEn1 > $fuerzaPj1){
                if($fuerzaEn1 > $durezaPj1){
                    $ganador = $nombreEn;
                }else{
                    $ganador = "Empate";
                }
            }else if($fuerzaEn1 < $fuerzaPj1){
                if($fuerzaPj1 > $durezaEn1){
                    $ganador = $nombrePj;
                }else{
                    $ganador = $nombreEn;
                }
            }else{
                if($fuerzaEn1 > $durezaPj1){
                    $ganador = $nombreEn;
                }else{
                    $ganador = $nombrePj;
                }
            }
        }else{
            if($fuerzaPj1 > $fuerzaEn1){
                if($fuerzaPj1 > $durezaEn1){
                    $ganador = $nombrePj;
                }else{
                    $ganador = "Empate";
                }
            }else if($fuerzaPj1 < $fuerzaEn1){
                if($fuerzaEn1 > $durezaPj1){
                    $ganador = $nombreEn;
                }else{
                    $ganador = $nombrePj;
                }
            }else{
                if($fuerzaPj1 > $durezaEn1){
                    $ganador = $nombrePj;
                }else{
                    $ganador = $nombreEn;
                }
            }
        }

        return array(
            'dañoPj' => $fuerzaPj1,
            'velocidadPj' => $velocidadPj1,
            'durezaPj' => $durezaPj1,
            'enemigo' => $nombreEn,
            'enemyfile' => $aleatorio,
            'ganador' => $ganador,
            'dañoEn' => $fuerzaEn1,
            'velocidadEn' => $velocidadEn1,
            'durezaEn' => $durezaEn1
        );
    }
    function backgroundImg($file) {
        $files = getFilenames($file);
        return getRandomObject($files);
    }
?>