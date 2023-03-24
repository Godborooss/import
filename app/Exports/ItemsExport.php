<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Xmlpack;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ItemsExport implements  FromCollection, WithHeadings, WithMapping
{
    protected $xmlpacks;

    public function __construct($xmlpacks)
    {
        $this->xmlpacks = $xmlpacks;
    }

    public function collection()
    {
        return $this->xmlpacks;
    }

    public function headings(): array
    {
        return [
            'A' => 'id',
            'B' => 'exporter',
            'C' => 'created_at',
        ];
    }

    public function map($xmlpack): array
    {
        return [
            $xmlpack->id,
             $xmlpack->exporter,
           $xmlpack->created_at
        ];
    }
}
