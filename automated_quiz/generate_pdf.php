<?php
session_start();
require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',24);
$pdf->Cell(0,20,'Certificate of Achievement',0,1,'C');

$pdf->SetFont('Arial','',16);
$pdf->Ln(10);
$pdf->Cell(0,10,'This certifies that',0,1,'C');

$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,$_SESSION['username'],0,1,'C');

$pdf->SetFont('Arial','',16);
$pdf->Cell(0,10,'has successfully completed the Online Quiz',0,1,'C');
$pdf->Cell(0,10,'Score: '.$_SESSION['score'].' / 5',0,1,'C');

$pdf->Ln(10);
$pdf->Cell(0,10,'Date: '.date("d M Y"),0,1,'C');

$pdf->Output();
?>