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
        //$this->Cell(80);

        // Add image (path to your image file, x and y position, width, and height)
        //$this->Image('assets/img/blue-curve-frame.png', 0, 0, 210, 297); // Adjust the path, x, y, width, and height
        //$this->Image('assets/img/smooth-purple-wavy.jpg', 0, -10, 210, 60); // Adjust the path, x, y, width, and height

        // Title
        $this->SetFillColor(21, 114, 232);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(190, 12, 'IT Service Requisition Form', 0, 1, 'C', true);

        // Line break
        $this->Ln(4);
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

        $pdf->SetFillColor(177, 208, 247);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(26, 8, "Request Code : ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(68, 8, iconv('UTF-8', 'windows-1252', "20250410083023-9979"), 0, 0, '', true);
        $pdf->Cell(2, 8, '', 0, 0);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(11, 8, "Date : ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(35, 8, "April 10, 2025", 0, 0, '', true);
        $pdf->Cell(2, 8, '', 0, 0);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(11, 8, "Time : ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(35, 8, "08:30:23 AM", 0, 1, '', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(25, 8, "Requested by : ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(69, 8, "Juan Dela Cruz", 0, 0, 'L', true);
        $pdf->Cell(2, 8, '', 0, 0);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(13, 8, "Office : ", 0, 0, '', true);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(81, 8, "ICTU Section Office of the RD / ARD", 0, 1, '', true);
        $pdf->Ln(2);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(23, 8, "Received by :", 0, 0, '', true);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 8, "Jondy Gonzales", 0, 1, '', true);
        $pdf->Ln(7);
        //----------------------------------------------------

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 8, 'Requesting to :', 'LTR', 1);

        $startY = $pdf->GetY(); // Save Y position to know where to start the box
        $startX = 10; // margin from left
        $boxWidth = 190;
        $lineHeight = 8;

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12); // Space after checkbox
        $pdf->Cell(85, 6, "Check Computer Desktop / Laptop", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 6, "Install Printer", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(85, 6, "Check Internet Connection", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 6, "Install Software Application", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(85, 6, "Check Monitor", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 6, "Biometrics Registration", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(85, 6, "Check Mouse / Keyboard", 0, 0);

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-empty.png', $pdf->GetX(), $pdf->GetY(), 6, 6);
        $pdf->Cell(8);
        $pdf->Cell(5, 6, "System Technical Asistance", 0, 1 );

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/assets/img/checkbox-checked.png', 15, $pdf->GetY(), 6, 6);
        $pdf->Cell(12);
        $pdf->Cell(0, 6, "Others : (Please Specify)", 0, 1);
        $pdf->Cell(12);
        $pdf->Cell(0, 6, "Please retrieve my files / For recovery", 0, 1);
        $pdf->Cell(12);
        $pdf->Cell(0, 6, "Sample Request Test", 0, 1);

        $endY = $pdf->GetY(); // Save ending Y to calculate height of the box
        $pdf->Rect($startX, $startY, $boxWidth, $endY - $startY); // Draw rectangle around the content
        $pdf->Ln(7);
        //--------------------------------------------------------------------------

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(21, 114, 232);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 10, 'IT Job Report Form', 0, 1, 'C', true);
        $pdf->Ln(4);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(52, 8, "Fault Detection :", 'LT', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 8, "Loose RJ45 connection", 'LTR', 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(52, 8, "Work Done :", 'LT', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 8, "Troubleshoot LAN connection and recrimp RJ45 connector", 'LTR', 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(52, 8, "Remarks / Recommendation :", 'LTB', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 8, "Solved", 'LTRB', 1);
        $pdf->Ln(7);
        //--------------------------------------------------------------------------

        $pdf->Cell(52, 8, "", 'LT', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(27, 8, "Date :", 'LT', 0);
        $pdf->Cell(111, 8, "April 10, 2025", 'TR', 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(52, 8, "Acted Upon :", 'L', 0, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(27, 8, "Time :", 'LT', 0);
        $pdf->Cell(111, 8, "08:32:15 AM", 'TR',1);

        $pdf->Cell(52, 8, "", 'LB', 0);
        $pdf->Cell(27, 8, "Serviced by :", 'LTB', 0);
        $pdf->Cell(111, 8, "Jondy Gonzales", 'TRB', 1);
        $pdf->Ln(7);
        //--------------------------------------------------------------------------

        $pdf->Cell(52, 8, "", 'LT', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(27, 8, "Date :", 'LT', 0);
        $pdf->Cell(111, 8, "April 10, 2025", 'TR', 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(52, 8, "Completion :", 'L', 0, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(27, 8, "Time :", 'LT', 0);
        $pdf->Cell(111, 8, "08:47:39 AM", 'TR',1);

        $pdf->Cell(52, 8, "", 'LB', 0);
        $pdf->Cell(27, 8, "Confirmed by :", 'LTB', 0);
        $pdf->Cell(111, 8, "Juan Dela Cruz", 'TRB', 1);
        $pdf->Ln(7);

        // Output the PDF
        $pdf->Output();
        exit;
    }
}
