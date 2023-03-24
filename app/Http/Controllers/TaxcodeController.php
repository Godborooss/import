<?php

namespace App\Http\Controllers;

use App\Models\Taxcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TaxcodeController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

//            $data = Receiver::latest()->get();
            $user_id = Auth::id();
            $data = Taxcode::latest()->where('user_id', $user_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editTaxcode">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTaxcode">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('taxcodes');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user_id = Auth::id();
        Taxcode::updateOrCreate([
            'id' => $request->taxcode_id
        ],
            [
                'taxcode' => $request->taxcode,
                'nameofproduct' => $request->nameofproduct,
                'user_id' => $user_id,
            ]);

        return response()->json(['success'=>'Taxcode saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Taxcode  $taxcode
     * @return \Illuminate\Http\Response
     */
    public function show(Taxcode $taxcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Taxcode  $taxcode
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $taxcode = Taxcode::find($id);
        return response()->json($taxcode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Taxcode $taxcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taxcode $taxcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Taxcode  $taxcode
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Taxcode::find($id)->delete();

        return response()->json(['success'=>'Taxcode deleted successfully.']);
    }
}
