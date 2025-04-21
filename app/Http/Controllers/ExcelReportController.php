<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Activity_request;

class ExcelReportController extends Controller
{
    public function generateExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Headers
        $sheet->setCellValue('A1', 'REQUEST CODE');
        $sheet->setCellValue('B1', 'REQUESTER');
        $sheet->setCellValue('C1', 'DESCRIPTION REQUESTS');
        $sheet->setCellValue('D1', 'TECHNICIAN');
        $sheet->setCellValue('E1', 'DATE COMPLETED');

        // Bold header row
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true
            ]
        ]);

        // Fetch data from the database
        $requests = Activity_request::with(['job_req', 'techFromUser'])
            ->where('status', 'completed')
            ->get();

        $row = 2; // Start from row 2
        foreach ($requests as $record) {
            $requester = optional($record->job_req->requester);
            $fullName = trim("{$requester->fname} {$requester->mname} {$requester->lname}");

            $technician = optional($record->techFromUser);
            $techFullName = trim("{$technician->fname} {$technician->mname} {$technician->lname}");

            $sheet->setCellValue("A$row", $record->request_code);
            $sheet->setCellValue("B$row", $fullName ?: 'N/A');
            $sheet->setCellValue("C$row", optional($record->job_req)->description ?? 'N/A');
            $sheet->setCellValue("D$row", $techFullName ?: $record->tech_from);
            $sheet->setCellValue("E$row", $record->updated_at ? $record->updated_at->format('Y-m-d') : 'N/A');

            $row++;
        }

        // Auto-size columns A to E
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Request_Report_' . now()->format('Ymd') . '.xlsx';

        return new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=\"$fileName\""
        ]);
    }
}
