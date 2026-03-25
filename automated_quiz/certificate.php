<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['score']) || $_SESSION['score'] < 3) {
    echo "You are not eligible for certificate.";
    exit();
}

require('fpdf/fpdf.php');

$name = $_SESSION['username'];
$score = $_SESSION['score'];

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',20);
        $this->Cell(0,15,'CERTIFICATE OF EXCELLENCE',0,1,'C');
        $this->Ln(10);
    }
}

$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial','',14);
$pdf->Cell(0,10,'This document certifies that',0,1,'C');

$pdf->SetFont('Arial','B',22);
$pdf->Cell(0,15,$name,0,1,'C');

$pdf->SetFont('Arial','',14);
$pdf->Cell(0,10,'has successfully passed the quiz assessment.',0,1,'C');

$pdf->Ln(10);

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,"Score: $score / 5",0,1,'C');

$pdf->Ln(20);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,"Date: ".date("Y-m-d"),0,1,'C');

$pdf->Output('D', 'certificate.pdf');
?>