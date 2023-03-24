<?php

namespace App\Imports;

use App\Models\Country;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Expection;
class ItemsImport implements ToModel, WithStartRow
{
    private $rowCounter;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function model(array $row)

    {
        $rowNumber = $this->getRowNumber();
        $user = DB::table('packs')
            ->latest()
            ->first();
        $taxCode = !empty($row[8]) ? $row[8] : null;
        $nameOfProduct = !empty($row[7]) ? $row[7] : null;


//        $country = strtolower($row[6]);
//        $iso = DB::table('countryisos')
//            ->where('country', $country)
//            ->value('iso');
//
//        if ($iso) {
//            $country = $iso;
//        }

        $country = strtoupper($row[6]);
        $iso = DB::table('countryisos')
            ->whereIn('country', [$country])
            ->orWhereIn('iso', [$country])
            ->value('iso');

        if (!$iso) {
                throw new \Exception('Error with country at row ' . $rowNumber . ': ' . $country);
        }
        return new Item([

            'name' => $row[0],
            'qty' => $row[1],
            'price' => $row[2],
            'netto' => $row[3],
            'brutto' => $row[4],
            'package' => $row[5],
            'country' => $iso,
            'nameofproduct' => $nameOfProduct,
            'taxcode' => $taxCode,

            'pack_id' =>$user->id ,


        ]);
    }
//    public function model(array $row)
//    {
//        $errors = [];
//
//        $user = DB::table('packs')
//            ->latest()
//            ->first();
//
//        $taxCode = !empty($row[8]) ? $row[8] : null;
//        $nameOfProduct = !empty($row[7]) ? $row[7] : null;
//
//        $country = strtolower($row[6]);
//
//        // Check if country exists in countryisos table
//        $country = strtolower($row[6]);
//        $iso = DB::table('countryisos')
//            ->whereIn('country', [$country])
//            ->orWhereIn('iso', [$country])
//            ->value('iso');
//
//        if (!$iso) {
//            throw new \Exception('Error with country: ' . $country);
//        }
//
//        // Create new item only if no errors
//        if (empty($errors)) {
//            return new Item([
//                'name' => $row[0],
//                'qty' => $row[1],
//                'price' => $row[2],
//                'netto' => $row[3],
//                'brutto' => $row[4],
//                'package' => $row[5],
//                'country' => $country,
//                'nameofproduct' => $nameOfProduct,
//                'taxcode' => $taxCode,
//                'packid' => $user->id,
//            ]);
//        } else {
//            // Add error to error collection
//            session()->flash('errors', collect($errors));
//            return null;
//        }
//    }
    public function startRow(): int
    {
        return 1;
    }
    private function getRowNumber()
    {
        return $this->rowCounter++;
    }
}
