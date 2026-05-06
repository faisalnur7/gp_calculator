<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\JewelleryCategory;
use App\Models\JewelleryItem;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

#[Signature('app:import-gold-calculator-excel {path? : Path to the Excel file}')] 
#[Description('Import jewellery document data from the Gold Calculator Excel file.')]
class ImportGoldCalculatorExcel extends Command
{
    public function handle()
    {
        $path = $this->argument('path') ?? base_path('../Gold Calculator.xlsx');

        if (! file_exists($path)) {
            $this->error("Excel file not found at {$path}");
            return 1;
        }

        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getSheetByName('Total') ?? $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        if (count($rows) < 2) {
            $this->error('No data rows found in the workbook.');
            return 1;
        }

        $defaultCategory = JewelleryCategory::firstOrCreate([
            'name' => 'Uncategorized',
        ], [
            'description' => 'Items imported without a defined category.',
        ]);

        $imported = 0;

        foreach (array_slice($rows, 1) as $index => $row) {
            $dateValue = trim($row['A'] ?? '');
            $shopName = trim($row['B'] ?? '');
            $itemName = trim($row['C'] ?? '');

            if (empty($shopName) || empty($itemName)) {
                continue;
            }

            $documentDate = $this->normalizeDate($dateValue);
            $shop = Shop::firstOrCreate(['name' => $shopName]);
            $item = JewelleryItem::firstOrCreate([
                'name' => $itemName,
            ], [
                'jewellery_category_id' => $defaultCategory->id,
                'description' => null,
            ]);

            $documentData = [
                'shop_id' => $shop->id,
                'jewellery_item_id' => $item->id,
                'document_date' => $documentDate,
                'reference_number' => null,
                'vori' => $this->castInt($row['D'] ?? null),
                'ana' => $this->castInt($row['E'] ?? null),
                'roti' => $this->castInt($row['F'] ?? null),
                'point' => $this->castInt($row['G'] ?? null),
                'total_vori' => $this->castInt($row['I'] ?? null),
                'total_ana' => $this->castInt($row['J'] ?? null),
                'total_roti' => $this->castInt($row['K'] ?? null),
                'total_points' => $this->castInt($row['L'] ?? null),
                'total_grams' => $this->castDecimal($row['H'] ?? null),
                'unit_price_per_gram' => $this->castDecimal($row['M'] ?? null),
                'subtotal' => $this->castDecimal($row['N'] ?? null),
                'notes' => null,
                'status' => 'imported',
            ];

            Document::create($documentData);
            $imported++;
        }

        $this->info("Imported {$imported} document records.");

        return 0;
    }

    private function normalizeDate(string $value): ?string
    {
        if ($value === '') {
            return null;
        }

        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject((int) $value)->format('Y-m-d');
            } catch (\Throwable) {
                // continue to fallback
            }
        }

        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $value)) {
            try {
                return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } catch (\Throwable) {
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    private function castInt($value): ?int
    {
        return is_numeric($value) ? (int) $value : null;
    }

    private function castDecimal($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return is_numeric($value) ? (string) floatval($value) : null;
    }
}
