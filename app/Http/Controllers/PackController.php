<?php

namespace App\Http\Controllers;

use App\Imports\ItemsImport;
use App\Models\Broker;
use App\Models\Company;
use App\Models\Item;
use App\Models\Pack;
use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $user_id = Auth::id();
        $packs = Pack::orderBy('created_at', 'desc')->with('receiver')->where('user_id', $user_id)->paginate(10);
        $receivers = Receiver::where('user_id', $user_id)->get();
        $senders = Sender::where('user_id', $user_id)->get();
        $brokers = Broker::where('user_id', $user_id)->get();
        return view('packs', compact('packs','receivers','senders','brokers'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'nameofpack' => ['required'],
//        ]);
//
//        try {
//            DB::transaction(function () use ($request) {
//                Pack::create($request->all());
//                Excel::import(new ItemsImport, request()->file('file'));
//            });
//        } catch (\Exception $e) {
//            $error = $e->getMessage();
//            return back()->with('error', $error);
//        }
//
//        return back()->with('success', 'File imported successfully!');
//    }

    public function createXml(Pack $pack)
    {
  if ($pack->container == null){
        try {
$xml = '<?xml version="1.0" encoding="UTF-8"?><ESADout_CU:ESADout_CU xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:catESAD_cu="urn:customs.ru:CUESADCommonAggregateTypesCust:5.10.0" xmlns:cat_ru="urn:customs.ru:CommonAggregateTypes:5.10.0" xmlns:ESADout_CU="urn:customs.ru:Information:CustomsDocuments:ESADout_CU:5.10.0" DocumentModeID="1006107E" xsi:schemaLocation="urn:customs.ru:Information:CustomsDocuments:ESADout_CU:5.10.0 ESADout_CU.xsd">
    <ESADout_CU:CustomsProcedure>IM</ESADout_CU:CustomsProcedure>
    <ESADout_CU:CustomsModeCode>40</ESADout_CU:CustomsModeCode>
    <ESADout_CU:ESADout_CUGoodsShipment>
        <catESAD_cu:OriginCountryName>ՉԻՆԱՍՏԱՆ</catESAD_cu:OriginCountryName>
        <catESAD_cu:SpecificationNumber>10</catESAD_cu:SpecificationNumber>
        <catESAD_cu:SpecificationListNumber>18</catESAD_cu:SpecificationListNumber>
        <catESAD_cu:TotalGoodsNumber>2</catESAD_cu:TotalGoodsNumber>
        <catESAD_cu:TotalPackageNumber>0</catESAD_cu:TotalPackageNumber>
        <catESAD_cu:TotalSheetNumber>2</catESAD_cu:TotalSheetNumber>
        <catESAD_cu:TotalCustCost>1912060</catESAD_cu:TotalCustCost>
        <catESAD_cu:CustCostCurrencyCode>AMD</catESAD_cu:CustCostCurrencyCode>
        <ESADout_CU:ESADout_CUConsignor>
            <cat_ru:OrganizationName>' .      $pack->sender->name . '</cat_ru:OrganizationName>
            <cat_ru:Address>
                <cat_ru:CountryCode>' . $pack->sender->country . '</cat_ru:CountryCode>
                <cat_ru:CounryName>ՉԻՆԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>' . $pack->sender->city . '</cat_ru:City>
                <cat_ru:StreetHouse>' . $pack->sender->address . '</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUConsignor>
        <ESADout_CU:ESADout_CUConsignee>
            <cat_ru:OrganizationName>«Վանարմկոմպ» ՍՊԸ</cat_ru:OrganizationName>
            <cat_ru:RAOrganizationFeatures>
                <cat_ru:UNN>' . $pack->receiver->hvhh . '</cat_ru:UNN>
            </cat_ru:RAOrganizationFeatures>
            <cat_ru:Address>
                <cat_ru:CountryCode>AM</cat_ru:CountryCode>
                <cat_ru:CounryName>ՀԱՅԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>ք.Վանաձոր</cat_ru:City>
                <cat_ru:StreetHouse>Կնունյանց փող. թիվ 43</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUConsignee>
        <ESADout_CU:ESADout_CUFinancialAdjustingResponsiblePerson>
            <cat_ru:OrganizationName>«Վանարմկոմպ» ՍՊԸ</cat_ru:OrganizationName>
            <cat_ru:RAOrganizationFeatures>
                <cat_ru:UNN>' . $pack->receiver->hvhh . '</cat_ru:UNN>
            </cat_ru:RAOrganizationFeatures>
            <cat_ru:Address>
                <cat_ru:CountryCode>AM</cat_ru:CountryCode>
                <cat_ru:CounryName>ՀԱՅԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>ք.Վանաձոր</cat_ru:City>
                <cat_ru:StreetHouse>Կնունյանց փող. թիվ 43</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUFinancialAdjustingResponsiblePerson>
        <ESADout_CU:ESADout_CUDeclarant>
            <cat_ru:OrganizationName>«Վանարմկոմպ» ՍՊԸ</cat_ru:OrganizationName>
            <cat_ru:RAOrganizationFeatures>
                <cat_ru:UNN>' . $pack->receiver->hvhh . '</cat_ru:UNN>
            </cat_ru:RAOrganizationFeatures>
            <cat_ru:Address>
                <cat_ru:CountryCode>AM</cat_ru:CountryCode>
                <cat_ru:CounryName>ՀԱՅԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>ք.Վանաձոր</cat_ru:City>
                <cat_ru:StreetHouse>Կնունյանց փող. թիվ 43</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUDeclarant>
        <ESADout_CU:ESADout_CUGoodsLocation>
            <ESADout_CU:InformationTypeCode>11</ESADout_CU:InformationTypeCode>
            <ESADout_CU:CustomsOffice>05100010</ESADout_CU:CustomsOffice>
            <ESADout_CU:CustomsCountryCode>AM</ESADout_CU:CustomsCountryCode>
            <ESADout_CU:GoodsLocationPlace>
                <catESAD_cu:NumberCustomsZone>MHT00007</catESAD_cu:NumberCustomsZone>
            </ESADout_CU:GoodsLocationPlace>
        </ESADout_CU:ESADout_CUGoodsLocation>
        <ESADout_CU:ESADout_CUConsigment>
            <catESAD_cu:ContainerIndicator>false</catESAD_cu:ContainerIndicator>
            <catESAD_cu:DispatchCountryCode>CN</catESAD_cu:DispatchCountryCode>
            <catESAD_cu:DispatchCountryName>ՉԻՆԱՍՏԱՆ</catESAD_cu:DispatchCountryName>
            <catESAD_cu:DestinationCountryCode>AM</catESAD_cu:DestinationCountryCode>
            <catESAD_cu:DestinationCountryName>ՀԱՅԱՍՏԱՆ</catESAD_cu:DestinationCountryName>
            <catESAD_cu:BorderCustomsOffice>
                <cat_ru:Code>05100041</cat_ru:Code>
                <cat_ru:OfficeName>ՄԵՂՐԻԻ ՄԱՔՍԱՅԻՆ ԿԵՏ-ԲԱԺԻՆ</cat_ru:OfficeName>
                <cat_ru:CustomsCountryCode>AM</cat_ru:CustomsCountryCode>
            </catESAD_cu:BorderCustomsOffice>
            <ESADout_CU:ESADout_CUDepartureArrivalTransport>
                <cat_ru:TransportModeCode>31</cat_ru:TransportModeCode>
                <cat_ru:TransportNationalityCode>GE</cat_ru:TransportNationalityCode>
                <ESADout_CU:TransportMeansQuantity>1</ESADout_CU:TransportMeansQuantity>
                <ESADout_CU:TransportMeans>
                    <cat_ru:TransportIdentifier>' . $pack->car_number . '</cat_ru:TransportIdentifier>
                    <cat_ru:TransportMeansNationalityCode>GE</cat_ru:TransportMeansNationalityCode>
                </ESADout_CU:TransportMeans>
            </ESADout_CU:ESADout_CUDepartureArrivalTransport>
            <ESADout_CU:ESADout_CUBorderTransport>
                <cat_ru:TransportModeCode>31</cat_ru:TransportModeCode>
                <cat_ru:TransportNationalityCode>GE</cat_ru:TransportNationalityCode>
                <ESADout_CU:TransportMeansQuantity>1</ESADout_CU:TransportMeansQuantity>
                <ESADout_CU:TransportMeans>
                    <cat_ru:TransportIdentifier>' . $pack->car_number . '</cat_ru:TransportIdentifier>
                    <cat_ru:TransportMeansNationalityCode>GE</cat_ru:TransportMeansNationalityCode>
                </ESADout_CU:TransportMeans>
            </ESADout_CU:ESADout_CUBorderTransport>
        </ESADout_CU:ESADout_CUConsigment>
        <ESADout_CU:ESADout_CUMainContractTerms>
            <catESAD_cu:ContractCurrencyCode>' . $pack->currency . '</catESAD_cu:ContractCurrencyCode>
            <catESAD_cu:ContractCurrencyRate>388.63</catESAD_cu:ContractCurrencyRate>
            <catESAD_cu:TotalInvoiceAmount>4920</catESAD_cu:TotalInvoiceAmount>
            <catESAD_cu:TradeCountryCode>CN</catESAD_cu:TradeCountryCode>
            <catESAD_cu:CUESADDeliveryTerms>
                <cat_ru:DeliveryPlace>Guangzhou</cat_ru:DeliveryPlace>
                <cat_ru:DeliveryTermsStringCode>FOB</cat_ru:DeliveryTermsStringCode>
            </catESAD_cu:CUESADDeliveryTerms>
        </ESADout_CU:ESADout_CUMainContractTerms>';





        $items = Item::where('pack_id', $pack->id)->get();
        foreach ($items as $item) {


            $xml .= '<ESADout_CU:ESADout_CUGoods>
            <catESAD_cu:GoodsNumeric>' . $item->id . '</catESAD_cu:GoodsNumeric>
            <catESAD_cu:GoodsDescription>' . $item->name . '</catESAD_cu:GoodsDescription>
            <catESAD_cu:GrossWeightQuantity>' . $item->brutto . '</catESAD_cu:GrossWeightQuantity>
            <catESAD_cu:NetWeightQuantity>' . $item->netto . '</catESAD_cu:NetWeightQuantity>
            <catESAD_cu:InvoicedCost>' . $item->price . '</catESAD_cu:InvoicedCost>
            <catESAD_cu:GoodsTNVEDCode>' . $item->taxcode . '</catESAD_cu:GoodsTNVEDCode>
            <catESAD_cu:OriginCountryCode>' . $item->country . '</catESAD_cu:OriginCountryCode>
            <catESAD_cu:OriginCountryName>ՉԻՆԱՍՏԱՆ</catESAD_cu:OriginCountryName>
            <catESAD_cu:CustomsCostCorrectMethod>' . $pack->method . '</catESAD_cu:CustomsCostCorrectMethod>
            <catESAD_cu:Preferencii>
                <catESAD_cu:CustomsTax>OO</catESAD_cu:CustomsTax>
                <catESAD_cu:Rate>OO</catESAD_cu:Rate>
            </catESAD_cu:Preferencii>
            <ESADout_CU:SupplementaryGoodsQuantity>
                <cat_ru:GoodsQuantity>' . $item->qty . '</cat_ru:GoodsQuantity>
                <cat_ru:MeasureUnitQualifierName>ՀԱՏ</cat_ru:MeasureUnitQualifierName>
                <cat_ru:MeasureUnitQualifierCode>796</cat_ru:MeasureUnitQualifierCode>
            </ESADout_CU:SupplementaryGoodsQuantity>
            <ESADout_CU:ESADGoodsPackaging>
                <catESAD_cu:PakageQuantity>20</catESAD_cu:PakageQuantity>
                <catESAD_cu:PakageTypeCode>1</catESAD_cu:PakageTypeCode>
                <catESAD_cu:PackingInformation>
                    <catESAD_cu:PackingCode>CS</catESAD_cu:PackingCode>
                    <catESAD_cu:PakingQuantity>' . $item->package. '</catESAD_cu:PakingQuantity>
                </catESAD_cu:PackingInformation>
            </ESADout_CU:ESADGoodsPackaging>
            <ESADout_CU:ESADCustomsProcedure>
                <catESAD_cu:MainCustomsModeCode>40</catESAD_cu:MainCustomsModeCode>
                <catESAD_cu:PrecedingCustomsModeCode>00</catESAD_cu:PrecedingCustomsModeCode>
                <catESAD_cu:GoodsTransferFeature>000</catESAD_cu:GoodsTransferFeature>
            </ESADout_CU:ESADCustomsProcedure>
        </ESADout_CU:ESADout_CUGoods>';

        }

        $xml .= '</ESADout_CU:ESADout_CUGoodsShipment>
    <ESADout_CU:FilledPerson>
        <cat_ru:PersonSurname>ՄԿՐՏՉՅԱՆ</cat_ru:PersonSurname>
        <cat_ru:PersonName>ԱՐՄԵՆ</cat_ru:PersonName>
        <catESAD_cu:Contact>
            <cat_ru:Phone>+37493756055</cat_ru:Phone>
            <cat_ru:E_mail>vanadzor@vanadzor.org</cat_ru:E_mail>
        </catESAD_cu:Contact>
    </ESADout_CU:FilledPerson>
</ESADout_CU:ESADout_CU>';

        } catch (\ErrorException $e) {
            return back()->with('errore','inchvor eror export xmli pahov');
        }

  } else {

      try {
          $xml = '<?xml version="1.0" encoding="UTF-8"?><ESADout_CU:ESADout_CU xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:catESAD_cu="urn:customs.ru:CUESADCommonAggregateTypesCust:5.10.0" xmlns:cat_ru="urn:customs.ru:CommonAggregateTypes:5.10.0" xmlns:ESADout_CU="urn:customs.ru:Information:CustomsDocuments:ESADout_CU:5.10.0" DocumentModeID="1006107E" xsi:schemaLocation="urn:customs.ru:Information:CustomsDocuments:ESADout_CU:5.10.0 ESADout_CU.xsd">
    <ESADout_CU:CustomsProcedure>IM</ESADout_CU:CustomsProcedure>
    <ESADout_CU:CustomsModeCode>40</ESADout_CU:CustomsModeCode>
    <ESADout_CU:ESADout_CUGoodsShipment>
        <catESAD_cu:OriginCountryName>ՉԻՆԱՍՏԱՆ</catESAD_cu:OriginCountryName>
        <catESAD_cu:SpecificationNumber>10</catESAD_cu:SpecificationNumber>
        <catESAD_cu:SpecificationListNumber>18</catESAD_cu:SpecificationListNumber>
        <catESAD_cu:TotalGoodsNumber>2</catESAD_cu:TotalGoodsNumber>
        <catESAD_cu:TotalPackageNumber>0</catESAD_cu:TotalPackageNumber>
        <catESAD_cu:TotalSheetNumber>2</catESAD_cu:TotalSheetNumber>
        <catESAD_cu:TotalCustCost>1912060</catESAD_cu:TotalCustCost>
        <catESAD_cu:CustCostCurrencyCode>AMD</catESAD_cu:CustCostCurrencyCode>
        <ESADout_CU:ESADout_CUConsignor>
            <cat_ru:OrganizationName>' .      $pack->sender->name . '</cat_ru:OrganizationName>
            <cat_ru:Address>
                <cat_ru:CountryCode>' . $pack->sender->country . '</cat_ru:CountryCode>
                <cat_ru:CounryName>ՉԻՆԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>' . $pack->sender->city . '</cat_ru:City>
                <cat_ru:StreetHouse>' . $pack->sender->address . '</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUConsignor>
        <ESADout_CU:ESADout_CUConsignee>
            <cat_ru:OrganizationName>«Վանարմկոմպ» ՍՊԸ</cat_ru:OrganizationName>
            <cat_ru:RAOrganizationFeatures>
                <cat_ru:UNN>' . $pack->receiver->hvhh . '</cat_ru:UNN>
            </cat_ru:RAOrganizationFeatures>
            <cat_ru:Address>
                <cat_ru:CountryCode>AM</cat_ru:CountryCode>
                <cat_ru:CounryName>ՀԱՅԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>ք.Վանաձոր</cat_ru:City>
                <cat_ru:StreetHouse>Կնունյանց փող. թիվ 43</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUConsignee>
        <ESADout_CU:ESADout_CUFinancialAdjustingResponsiblePerson>
            <cat_ru:OrganizationName>«Վանարմկոմպ» ՍՊԸ</cat_ru:OrganizationName>
            <cat_ru:RAOrganizationFeatures>
                <cat_ru:UNN>' . $pack->receiver->hvhh . '</cat_ru:UNN>
            </cat_ru:RAOrganizationFeatures>
            <cat_ru:Address>
                <cat_ru:CountryCode>AM</cat_ru:CountryCode>
                <cat_ru:CounryName>ՀԱՅԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>ք.Վանաձոր</cat_ru:City>
                <cat_ru:StreetHouse>Կնունյանց փող. թիվ 43</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUFinancialAdjustingResponsiblePerson>
        <ESADout_CU:ESADout_CUDeclarant>
            <cat_ru:OrganizationName>«Վանարմկոմպ» ՍՊԸ</cat_ru:OrganizationName>
            <cat_ru:RAOrganizationFeatures>
                <cat_ru:UNN>' . $pack->receiver->hvhh . '</cat_ru:UNN>
            </cat_ru:RAOrganizationFeatures>
            <cat_ru:Address>
                <cat_ru:CountryCode>AM</cat_ru:CountryCode>
                <cat_ru:CounryName>ՀԱՅԱՍՏԱՆ</cat_ru:CounryName>
                <cat_ru:City>ք.Վանաձոր</cat_ru:City>
                <cat_ru:StreetHouse>Կնունյանց փող. թիվ 43</cat_ru:StreetHouse>
            </cat_ru:Address>
        </ESADout_CU:ESADout_CUDeclarant>
        <ESADout_CU:ESADout_CUGoodsLocation>
            <ESADout_CU:InformationTypeCode>11</ESADout_CU:InformationTypeCode>
            <ESADout_CU:CustomsOffice>05100010</ESADout_CU:CustomsOffice>
            <ESADout_CU:CustomsCountryCode>AM</ESADout_CU:CustomsCountryCode>
            <ESADout_CU:GoodsLocationPlace>
                <catESAD_cu:NumberCustomsZone>MHT00007</catESAD_cu:NumberCustomsZone>
            </ESADout_CU:GoodsLocationPlace>
        </ESADout_CU:ESADout_CUGoodsLocation>
        <ESADout_CU:ESADout_CUConsigment>
            <catESAD_cu:ContainerIndicator>true</catESAD_cu:ContainerIndicator>
            <catESAD_cu:DispatchCountryCode>CN</catESAD_cu:DispatchCountryCode>
            <catESAD_cu:DispatchCountryName>ՉԻՆԱՍՏԱՆ</catESAD_cu:DispatchCountryName>
            <catESAD_cu:DestinationCountryCode>AM</catESAD_cu:DestinationCountryCode>
            <catESAD_cu:DestinationCountryName>ՀԱՅԱՍՏԱՆ</catESAD_cu:DestinationCountryName>
            <catESAD_cu:BorderCustomsOffice>
                <cat_ru:Code>05100041</cat_ru:Code>
                <cat_ru:OfficeName>ՄԵՂՐԻԻ ՄԱՔՍԱՅԻՆ ԿԵՏ-ԲԱԺԻՆ</cat_ru:OfficeName>
                <cat_ru:CustomsCountryCode>AM</cat_ru:CustomsCountryCode>
            </catESAD_cu:BorderCustomsOffice>
            <ESADout_CU:ESADout_CUDepartureArrivalTransport>
                <cat_ru:TransportModeCode>31</cat_ru:TransportModeCode>
                <cat_ru:TransportNationalityCode>IR</cat_ru:TransportNationalityCode>
                <ESADout_CU:TransportMeansQuantity>1</ESADout_CU:TransportMeansQuantity>
                <ESADout_CU:TransportMeans>
                    <cat_ru:TransportIdentifier>'.$pack->car_number.'</cat_ru:TransportIdentifier>
                    <cat_ru:TransportMeansNationalityCode>IR</cat_ru:TransportMeansNationalityCode>
                </ESADout_CU:TransportMeans>
            </ESADout_CU:ESADout_CUDepartureArrivalTransport>
            <ESADout_CU:ESADout_CUBorderTransport>
                <cat_ru:TransportModeCode>31</cat_ru:TransportModeCode>
                <cat_ru:TransportNationalityCode>IR</cat_ru:TransportNationalityCode>
                <ESADout_CU:TransportMeansQuantity>1</ESADout_CU:TransportMeansQuantity>
                <ESADout_CU:TransportMeans>
                    <cat_ru:TransportIdentifier>'. $pack->car_number .'</cat_ru:TransportIdentifier>
                    <cat_ru:TransportMeansNationalityCode>IR</cat_ru:TransportMeansNationalityCode>
                </ESADout_CU:TransportMeans>
            </ESADout_CU:ESADout_CUBorderTransport>
        </ESADout_CU:ESADout_CUConsigment>
        <ESADout_CU:ESADout_CUMainContractTerms>
            <catESAD_cu:ContractCurrencyCode>' . $pack->currency . '</catESAD_cu:ContractCurrencyCode>
            <catESAD_cu:ContractCurrencyRate>388.63</catESAD_cu:ContractCurrencyRate>
            <catESAD_cu:TotalInvoiceAmount>4920</catESAD_cu:TotalInvoiceAmount>
            <catESAD_cu:TradeCountryCode>CN</catESAD_cu:TradeCountryCode>
            <catESAD_cu:CUESADDeliveryTerms>
                <cat_ru:DeliveryPlace>Guangzhou</cat_ru:DeliveryPlace>
                <cat_ru:DeliveryTermsStringCode>FOB</cat_ru:DeliveryTermsStringCode>
            </catESAD_cu:CUESADDeliveryTerms>
        </ESADout_CU:ESADout_CUMainContractTerms>';





          $items = Item::where('pack_id', $pack->id)->get();
          foreach ($items as $item) {


              $xml .= '<ESADout_CU:ESADout_CUGoods>
            <catESAD_cu:GoodsNumeric>' . $item->id . '</catESAD_cu:GoodsNumeric>
            <catESAD_cu:GoodsDescription>' . $item->name . '</catESAD_cu:GoodsDescription>
            <catESAD_cu:GrossWeightQuantity>' . $item->brutto . '</catESAD_cu:GrossWeightQuantity>
            <catESAD_cu:NetWeightQuantity>' . $item->netto . '</catESAD_cu:NetWeightQuantity>
            <catESAD_cu:InvoicedCost>' . $item->price . '</catESAD_cu:InvoicedCost>
            <catESAD_cu:GoodsTNVEDCode>' . $item->taxcode . '</catESAD_cu:GoodsTNVEDCode>
            <catESAD_cu:OriginCountryCode>' . $item->country . '</catESAD_cu:OriginCountryCode>
            <catESAD_cu:OriginCountryName>ՉԻՆԱՍՏԱՆ</catESAD_cu:OriginCountryName>
            <catESAD_cu:CustomsCostCorrectMethod>' . $pack->method . '</catESAD_cu:CustomsCostCorrectMethod>
            <catESAD_cu:Preferencii>
                <catESAD_cu:CustomsTax>OO</catESAD_cu:CustomsTax>
                <catESAD_cu:Rate>OO</catESAD_cu:Rate>
            </catESAD_cu:Preferencii>
            <ESADout_CU:SupplementaryGoodsQuantity>
                <cat_ru:GoodsQuantity>' . $item->qty . '</cat_ru:GoodsQuantity>
                <cat_ru:MeasureUnitQualifierName>ՀԱՏ</cat_ru:MeasureUnitQualifierName>
                <cat_ru:MeasureUnitQualifierCode>796</cat_ru:MeasureUnitQualifierCode>
            </ESADout_CU:SupplementaryGoodsQuantity>
            <ESADout_CU:ESADGoodsPackaging>
                <catESAD_cu:PakageQuantity>20</catESAD_cu:PakageQuantity>
                <catESAD_cu:PakageTypeCode>1</catESAD_cu:PakageTypeCode>
                <catESAD_cu:PackingInformation>
                    <catESAD_cu:PackingCode>CS</catESAD_cu:PackingCode>
                    <catESAD_cu:PakingQuantity>' . $item->package. '</catESAD_cu:PakingQuantity>
                </catESAD_cu:PackingInformation>
            </ESADout_CU:ESADGoodsPackaging>
            <ESADout_CU:ESADContainer>
                <catESAD_cu:ContainerQuantity>1</catESAD_cu:ContainerQuantity>
                <catESAD_cu:ContainerKind>ME</catESAD_cu:ContainerKind>
                <catESAD_cu:ContainerNumber>
                    <catESAD_cu:ContainerIdentificaror>' . $pack->container . '</catESAD_cu:ContainerIdentificaror>
                    <catESAD_cu:FullIndicator>2</catESAD_cu:FullIndicator>
                </catESAD_cu:ContainerNumber>
            </ESADout_CU:ESADContainer>
            <ESADout_CU:ESADCustomsProcedure>
                <catESAD_cu:MainCustomsModeCode>40</catESAD_cu:MainCustomsModeCode>
                <catESAD_cu:PrecedingCustomsModeCode>00</catESAD_cu:PrecedingCustomsModeCode>
                <catESAD_cu:GoodsTransferFeature>000</catESAD_cu:GoodsTransferFeature>
            </ESADout_CU:ESADCustomsProcedure>
        </ESADout_CU:ESADout_CUGoods>';

          }

          $xml .= '</ESADout_CU:ESADout_CUGoodsShipment>
    <ESADout_CU:FilledPerson>
        <cat_ru:PersonSurname>ՄԿՐՏՉՅԱՆ</cat_ru:PersonSurname>
        <cat_ru:PersonName>ԱՐՄԵՆ</cat_ru:PersonName>
        <catESAD_cu:Contact>
            <cat_ru:Phone>+37493756055</cat_ru:Phone>
            <cat_ru:E_mail>vanadzor@vanadzor.org</cat_ru:E_mail>
        </catESAD_cu:Contact>
    </ESADout_CU:FilledPerson>
</ESADout_CU:ESADout_CU>';

      } catch (\ErrorException $e) {
          return back()->with('errore','inchvor eror export xmli pahov');
      }

  }
        $headers = [
            'Content-type' => 'text/xml',
            'Content-Disposition' => 'attachment; filename="' . $pack->nameofpack . '.xml"',
        ];

        return Response::make($xml, 200, $headers);
    }

    public function show($id)
    {
        $items = Item::with('item')->get();
        $pack = Pack::findOrFail($id);
        if ($pack->user_id != Auth::id()) {
            return redirect()->route('packs.index')->with('error', 'You are not authorized to access this package');
        }
        return view('packages.show',compact('pack','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCompany(Request $request, Pack $pack)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->save();

        $pack = Pack::find($request->pack_id);
        $pack->company_id = $company->id;
        $pack->save();

        return back();
    }
    public function edit(Pack $pack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pack $pack)
    {
        // Получение всех данных из формы
        $data = $request->all();

        // Сохранение выбранных значений из селектов в модели
        if (isset($data['receiver_id'])) {
            $pack->receiver_id = $data['receiver_id'];
        }

        if (isset($data['sender_id'])) {
            $pack->sender_id = $data['sender_id'];
        }

        if (isset($data['broker_id'])) {
            $pack->broker_id = $data['broker_id'];
        }

        if (isset($data['method'])) {
            $pack->method = $data['method'];
        }

        if (isset($data['currency'])) {
            $pack->currency = $data['currency'];
        }

        if (isset($data['container'])) {
            $pack->container = $data['container'];
        }

        if (isset($data['shipping_term'])) {
            $pack->shipping_term = $data['shipping_term'];
        }

        if (isset($data['car_number'])) {
            $pack->car_number = $data['car_number'];
        }
         // Сохранение модели в базу данных
        $pack->save();


        // Редирект на страницу списка пакетов
        return redirect()->route('packs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pack $pack)
    {
        //
    }
}
