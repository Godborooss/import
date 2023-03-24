<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Imports\ItemsImport;

use App\Models\Item;
use App\Models\Pack;
use App\Models\Taxcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new ItemsExport, 'output.xlsx');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $data = $request->all();

        foreach ($data['nameofproducts'] as $id => $nameofproduct) {
            $user_id = Auth::id();


            $item = Item::findOrFail($id);
            $item->nameofproduct = $nameofproduct;
            $item->taxcode = DB::table('taxcodes')->where('user_id', $user_id)->where('nameofproduct',$nameofproduct)->value('taxcode');
            $item->save();
        }
        return redirect()->back()->with('success', 'Users updated successfully.');
    }
    public function import(Request $request)
    {
        $request->validate([
            'nameofpack' => ['required'],
            'file' => ['required', 'file', 'mimes:xls,xlsx,csv'],
        ]);
        try {
            DB::transaction(function () use ($request) {
                // Add user_id to request data
                $request->merge(['user_id' => auth()->user()->id]);
                Pack::create($request->all());
                Excel::import(new ItemsImport, request()->file('file'));
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->validate([
//
//            'name' => ['required'],
//            'nameofpack' => ['required'],
//        ]);
//        DB::transaction(function () use ( $request) {
//
//            Pack::create([
//
//                'nameofpack' => $request['nameofpack'],
//                'price' => $request['price'],
//                'product_id' => $request['product_id'],
//            ]);
//            Excel::import(new ItemsImport,request()->file('file'));
//        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Pack $pack)
    {
        $items = Item::with('item')->get();





        return view('packages.show',compact('pack','items'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function autocomplete(Request $request)
    {

//        $data = mysqli_query("SELECT * FROM users WHERE name LIKE '%".$term[0]."%' and name like '%".$term[1]."%' and name like '%".$term[2]."%' LIMIT 10 ") ->get();

        $user_id = Auth::id();
//     $data = DB::table('users')->select('female')->where('female', 'LIKE', '%'. $request->get('query'). '%')->pluck('female');
        $data = Taxcode::select('id', 'nameofproduct')->where('user_id', $user_id)
            ->where('nameofproduct', 'LIKE', '%'. $request->get('query'). '%')
            ->pluck('nameofproduct');

        return response()->json($data);

    }
//    public function autocomplete(Request $request)
//    {
//
////        $data = mysqli_query("SELECT * FROM users WHERE name LIKE '%".$term[0]."%' and name like '%".$term[1]."%' and name like '%".$term[2]."%' LIMIT 10 ") ->get();
//
//
////     $data = DB::table('users')->select('female')->where('female', 'LIKE', '%'. $request->get('query'). '%')->pluck('female');
////        $data = Taxcode::select("nameofproduct")
////            ->where('nameofproduct', 'LIKE', '%'. $request->get('query'). '%')
////            ->pluck('nameofproduct');
////
////        return response()->json($data);
//        $search = $request->get('query');
//        $data = Taxcode::select('id', 'nameofproduct')
//            ->where('nameofproduct', 'LIKE', '%' . $search . '%')
//            ->get();
//
//        return response()->json($data);
//
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateItem(Request $request )
    {

//        if ($request->ajax()) {
//            Item::find($request->pk)
//                ->update([
//                    $request->name => $request->value
//                ]);
//
//            return response()->json(['success' => true]);
//        }
        $user_id = Auth::id();
        $item = Item::findOrFail($request->pk);
        $item->{$request->name} = $request->value;
        if ($request->name === 'name') {
            $taxcode = Taxcode::where('user_id', $user_id)->where('nameofproduct', 'like', $request->value . '%')->first();
            if ($taxcode) {
                $item->taxcode = $taxcode->taxcode;
            }
        }
        $item->save();
        return response()->json(['success' => true]);
    }
    public function getTaxcodes(Request $request)
    {
        $user_id = Auth::id();
        $search = $request->input('search');
        $taxcodes = Taxcode::where('user_id', $user_id)->where('nameofproduct', 'LIKE', '%'.$search.'%')->get();
        $result = [];
        foreach ($taxcodes as $taxcode) {
            $result[] = [
                'value' => $taxcode->nameofproduct,
                'label' => $taxcode->nameofproduct,
                'taxcode' => $taxcode->taxcode
            ];
        }
        return response()->json($result);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
