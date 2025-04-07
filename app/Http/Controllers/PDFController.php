<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FPDF;

class CustomPDF extends \FPDF
{
    // Header Method
    function Header()
    {
        // Set font
        $this->SetFont('Arial', 'B', 12);

        // Move to the right
        $this->Cell(80);

        // Add image (path to your image file, x and y position, width, and height)
        $this->Image('assets/img/blue-curve-frame.png', 0, 0, 210, 297); // Adjust the path, x, y, width, and height
        //$this->Image('assets/img/smooth-purple-wavy.jpg', 0, -10, 210, 60); // Adjust the path, x, y, width, and height

        // Title
        $this->Cell(30, 10, 'IT Service Request Form', 0, 1, 'C');

        // Line break
        $this->Ln(5);
    }

    // Footer Method
    function Footer()
    {
        // Set position at 1.5 cm from bottom
        $this->SetY(-15);

        //$this->Image('assets/img/smooth-purple-wavyFooter.jpg', 0, 250, 210, 60); // Adjust the path, x, y, width, and height

        // Set font
        $this->SetFont('Arial', 'I', 8);

        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

class PDFController extends Controller
{
    public function generatePDF()
    {
        $pdf = new CustomPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Juan Dela Cruz');

        // Output the PDF
        $pdf->Output();
        exit;
    }
}
