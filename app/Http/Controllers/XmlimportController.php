<?php

namespace App\Http\Controllers;

use App\Models\Xmlimport;
use App\Models\Xmlpack;
use App\Models\Xmlpackitem;
use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemsExport;
class XmlimportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function index()
    {
        return view('xmlimport');
    }
    public function import(Request $request)
    {
        $xmlFile = $request->file('xmlFile');
        $dom = new DOMDocument();
        $dom->load($xmlFile);

// Получить значения TotalSheetNumber и TotalCustCost из XML-файла
//        $number = $dom->getElementsByTagName('TotalSheetNumber')->item(0)->nodeValue;
//        $cost = $dom->getElementsByTagName('TotalCustCost')->item(0)->nodeValue;
//        $costcode=$dom->getElementsByTagName('CustCostCurrencyCode')->item(0)->nodeValue;
//        $companyfrom = $dom->getElementsByTagName('ESADout_CUConsignee')->getElementsByTagName('OrganizationName')->item(0)->nodeValue;
        $consignor = $dom->getElementsByTagName('ESADout_CUConsignor')->item(0);

// Находим элемент <cat_ru:OrganizationName> внутри элемента <ESADout_CUConsignor>
        $organizationName = $consignor->getElementsByTagName('OrganizationName')->item(0)->nodeValue;
$user_id = Auth::id();
// Сохранить значения TotalSheetNumber и TotalCustCost в базу данных
        $xmlpackId = DB::table('xmlpacks')->insertGetId([
           'user_id'=> $user_id,
            'exporter' => $organizationName,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

// Получить все продукты из XML-файла
        $orgnames = $dom->getElementsByTagName('ESADout_CUConsignor');
        $orgfroms = $dom->getElementsByTagName('ESADout_CUConsignee');
        $contactinfos = $dom->getElementsByTagName('ESADout_CUMainContractTerms');
        $products = $dom->getElementsByTagName('ESADout_CUGoods');

// Сохранить каждый продукт в базу данных
        foreach ($products as $product) {


            $name= $product->getElementsByTagName('GoodsDescription')->item(0)->nodeValue;
            $code= $product->getElementsByTagName('GoodsTNVEDCode')->item(0)->nodeValue;
            $brutto= $product->getElementsByTagName('GrossWeightQuantity')->item(0)->nodeValue;
            $netto= $product->getElementsByTagName('NetWeightQuantity')->item(0)->nodeValue;
            $price= $product->getElementsByTagName('InvoicedCost')->item(0)->nodeValue;
            $country_name= $product->getElementsByTagName('OriginCountryName')->item(0)->nodeValue;
            $country_code= $product->getElementsByTagName('OriginCountryCode')->item(0)->nodeValue;
            $package_quantity= $product->getElementsByTagName('PakingQuantity')->item(0)->nodeValue;
            $unit_code= $product->getElementsByTagName('MeasureUnitQualifierCode')->item(0)->nodeValue;


            $qty= $product->getElementsByTagName('GoodsQuantity')->item(0)->nodeValue;
            $unit_name= $product->getElementsByTagName('MeasureUnitQualifierName')->item(0)->nodeValue;
            foreach ($orgnames as $orgname){
                $company_name = $orgname->getElementsByTagName('OrganizationName')->item(0)->nodeValue;
            }
            foreach ($orgfroms as $orgfrom){
                $company_from= $orgfrom->getElementsByTagName('OrganizationName')->item(0)->nodeValue;
            }
            foreach ($contactinfos as $contactinfo){
                $currency_name= $contactinfo->getElementsByTagName('ContractCurrencyCode')->item(0)->nodeValue;
                $currency_rate= $contactinfo->getElementsByTagName('ContractCurrencyRate')->item(0)->nodeValue;

            }



            // Сохранить продукт в таблице xmlpackitems с указанием xmlpack_id
            DB::table('xmlpackitems')->insert([


                'name' => $name,
                'code' => $code,
                'brutto' => $brutto,
                'netto' => $netto,
                'price' => $price,
                'unit_code' => $unit_code,
                'country_name' => $country_name,
                'country_code' => $country_code,
                'currency_name' => $currency_name,
              'currency_rate' => $currency_rate,
                'package_quantity' => $package_quantity,
                'qty' => $qty,
                'unit_name' => $unit_name,
              'company_name' => $company_name,
               'company_from' => $company_from,

                'xmlpack_id' => $xmlpackId,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
            return redirect()->back()->with('success', 'Файл успешно импортирован.');

    }
    public function exportindex()
    {
        $xmlpacks = Xmlpack::orderBy('created_at', 'desc')->paginate(5);

        return view('exportxlsx',compact('xmlpacks'));
    }
    public function exportXmlpacks($id)
    {

        $xmlpackse = Xmlpack::where('id', $id)->get();

        return Excel::download(new ItemsExport($xmlpackse), 'xmlpacks.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Xmlimport  $xmlimport
     * @return \Illuminate\Http\Response
     */
    public function show(Xmlimport $xmlimport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Xmlimport  $xmlimport
     * @return \Illuminate\Http\Response
     */
    public function edit(Xmlimport $xmlimport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Xmlimport  $xmlimport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Xmlimport $xmlimport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Xmlimport  $xmlimport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Xmlimport $xmlimport)
    {
        //
    }
}
