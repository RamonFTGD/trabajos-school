<?php
    require('../lib/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',22);
    $pdf->Cell(190,20,'Centro de Estudios Tecnologicos y de Servicios No. 084', 0, 5, "C", false, "");
    $pdf->Ln();$pdf->Ln();
    $pdf->setFont("Arial", "", 14);
    $pdf->SetLineWidth(1);
    $pdf->SetDrawColor(0, 238, 255);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(0, 156, 8);
    $pdf->cell(125, 10, "Desarrolla paginas web con Conexion a base de Datos", 1, 2, "C", true);
    $pdf->SetFont('Arial','B',12);
    $pdf->Ln();$pdf->Ln();
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(194, 174, 0);
    $pdf->Cell(86,10, utf8_decode("Alumno: Heriberto Ramòn Luna Figueroa"), 1, 2, "C", true);
    $pdf->Ln();
    $pdf->Cell(84,10, utf8_decode("Maestro: Gabriel Ignacio China Cortez"), 1, 2, "C", true);
    $pdf->Output();
?>