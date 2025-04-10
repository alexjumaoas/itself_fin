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
        //$this->Image('assets/img/blue-curve-frame.png', 0, 0, 210, 297); // Adjust the path, x, y, width, and height
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

        $pdf->SetFillColor(221, 224, 247);
        //$pdf->SetFillColor(203, 223, 249);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(27, 8, "Requested by: ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(116, 8, "Juan Dela Cruz", 0, 0, 'L', true);
        $pdf->Cell(2, 8, '', 0, 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(13, 8, "Date: ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 8, "April 10, 2025", 0, 1, '', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(13, 8, "Office: ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(130, 8, "ICTU Section Office of the RD / ARD", 0, 0, '', true);
        $pdf->Cell(2, 8, '', 0, 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(13, 8, "Time: ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 8, "08:30:23 AM", 0, 1, '', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(27, 8, "Request Code: ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 8, iconv('UTF-8', 'windows-1252', "20250407131824-9979"), 0, 1, '', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 8, "Received by: ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 8, "John Doe", 0, 1, '', true);
        $pdf->Ln(7);

        //----------------------------------------------------


        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 8, 'Requesting to : ', '', 1);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 10);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12); // Space after checkbox
        $pdf->Cell(85, 8, "Check Computer Desktop / Laptop", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 8, "Install Printer", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(85, 8, "Check Internet Connection", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 8, "Install Software Application", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(85, 8, "Check Monitor", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 8, "Biometrics Registration", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(85, 8, "Check Mouse / Keyboard", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 8, "System Technical Asistance", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(85, 8, "Others: Please Specify", 0, 1);
        $pdf->Cell(12);
        $pdf->Cell(85, 8, "Please retrieve my files / For recovery ", 0, 1);







        // Output the PDF
        $pdf->Output();
        exit;
    }
}
