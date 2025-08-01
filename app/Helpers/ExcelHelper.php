<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Response;

class ExcelHelper
{
    public static function tempPath(string $path = ''): string
    {
        return storage_path('/');
    }

    public static function saveFromArray(array $data, string $path): void
    {
        $spreadsheet = new Spreadsheet();

        $n = 1;
        foreach ($data as $name => $rows) {
            $worksheet_name = 'worksheet' . $n;
            if ($n == 1) {
                ${$worksheet_name} = $spreadsheet->getActiveSheet();
            } else {
                ${$worksheet_name} = $spreadsheet->createSheet();
            }
            ${$worksheet_name}->fromArray($rows);
            ${$worksheet_name}->setTitle($name);
            $n++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);
    }

    public static function getSheetsList(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        return $spreadsheet->getSheetNames();
    }

    public static function readFromFile(string $path, ?string $sheet_name = null): array
    {
        $spreadsheet = IOFactory::load($path);

        $sheet = $sheet_name
            ? $spreadsheet->getSheetByName($sheet_name)
            : $spreadsheet->getActiveSheet();

        return $sheet->toArray();
    }

    public static function sheetFromArray(array $data, string $path): string
    {
        $spreadsheet = new Spreadsheet();
        foreach ($data as $k => $datum) {
            $headings = $datum['headings'];
            $prepend = $datum['prepend'] ?? [];
            $append = $datum['append'] ?? [];

            if ($k == 0)
                $activeSheet = $spreadsheet->getActiveSheet();
            else
                $activeSheet = $spreadsheet->createSheet();
            $activeSheet->setTitle($datum['sheet_name']);
            $mappedData = array_map(function ($item) use ($data, $headings) {
                $item = (array)$item;
                $item = array_intersect_key($item, $headings);
                return array_values($item);
            }, $datum['list']);
            $shhetData = array_merge($prepend, [$headings], $mappedData, $append);
            $activeSheet->fromArray($shhetData);
        }

        $writer = new Xlsx($spreadsheet);
        $fullPath = self::tempPath($path);
        $writer->save(self::tempPath($path));

        return $fullPath;
    }

    public static function exportAsDownload(array $data, string $file_name = 'export.xlsx', string $format = 'xlsx'): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $n = 1;

        foreach ($data as $name => $rows) {
            $worksheetName = 'worksheet' . $n;

            if ($n === 1) {
                ${$worksheetName} = $spreadsheet->getActiveSheet();
            } else {
                ${$worksheetName} = $spreadsheet->createSheet();
            }

            ${$worksheetName}->fromArray($rows);
            ${$worksheetName}->setTitle($name);
            $n++;
        }

        // Choose the writer based on the specified format
        if ($format === 'xls') {
            $writer = new Xls($spreadsheet);
            $file_name = preg_replace('/\.(xlsx|xls)$/', '.xls', $file_name); // Ensure correct extension
            $contentType = 'application/vnd.ms-excel';
        } else {
            $writer = new Xlsx($spreadsheet);
            $file_name = preg_replace('/\.(xlsx|xls)$/', '.xlsx', $file_name); // Ensure correct extension
            $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        }

        // Create a stream to write the file in-memory
        return Response::stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $file_name . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
