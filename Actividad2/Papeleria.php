<?php
    include "bd.php";
    require("../lib/fpdf.php");
    $pdf = new FPDF();
    $pdf -> AddPage();
    $result = $pdo->prepare("SELECT * FROM productos");
    $result->execute();
    $cl1 = 10;
    $cl2 = 80;
    $cl3 = 20;
    $x = $pdf->GetPageWidth();
    $y = $pdf->GetPageHeight();
    $pdf->SetFont("Arial", "B", 14);
    $pdf->SetMargins(50,5,50);
    $pdf->cell(1, 10, "", 0, 1, "C", false, "");
    $pdf->Cell($cl1, 10, "Id", 1, 0, "C", false, "");
    $pdf->Cell($cl2, 10, "Nombre", 1, 0, "C", false, "");
    $pdf->Cell($cl3, 10, "Precio", 1, 1, "C", false, "");
    $pdf->SetFont("Arial", "", 12);
    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $pdf->Cell($cl1, 10, $row["id"], 1, 0, "L", false, "");
            $pdf->Cell($cl2, 10, utf8_decode($row["nombre"]), 1, 0, "C", false, "");
            $pdf->Cell($cl3, 10, "$".$row["precio"], 1, 1, "C", false, "");
        }
    } else {
        $pdf->Cell(30, 100, "No se encontraron resultados.", 0 , 1, "C", false, "");
    }
    $pdf->SetFont("Arial", "", 15);
    $pdf->SetTextColor(0, 7, 87);
    $pdf->Text($x/3.2, $y-10, utf8_decode("Nombre: Heriberto Ramón Luna Figueroa"));
    $pdf->Text($x/3.2, $y-5, utf8_decode("Maestro: Gabriel China Ignácio Cortez"));
    $pdf -> Output();
    //pdf normal nombre y cebetis. una tabla. una tabla a la base de datos. la invetigacion.
?>