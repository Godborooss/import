<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BrokerController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

//            $data = Receiver::latest()->get();
            $user_id = Auth::id();
            $data = Broker::latest()->where('user_id', $user_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBroker">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBroker">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('brokers');
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
        Broker::updateOrCreate([
            'id' => $request->broker_id
        ],
            [
                'name' => $request->name,
                'hvhh' => $request->hvhh,
                'user_id' => $user_id,


            ]);

        return response()->json(['success'=>'Broker saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\Response
     */
    public function show(Broker $broker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $broker = Broker::find($id);
        return response()->json($broker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Broker $broker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Broker::find($id)->delete();

        return response()->json(['success'=>'Broker deleted successfully.']);
    }
}
