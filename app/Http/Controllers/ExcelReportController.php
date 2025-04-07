<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelReportController extends Controller
{
    public function generateExcel()
    {
        // Create new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');

        // Dummy Data (Replace with database query)
        $data = [
            [1, 'John Doe', 'john@example.com'],
            [2, 'Jane Doe', 'jane@example.com']
        ];

        $row = 2; // Start from row 2
        foreach ($data as $record) {
            $sheet->setCellValue("A$row", $record[0]);
            $sheet->setCellValue("B$row", $record[1]);
            $sheet->setCellValue("C$row", $record[2]);
            $row++;
        }

        // Create Writer
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Request Report.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=\"$fileName\""
        ]);
    }
}
