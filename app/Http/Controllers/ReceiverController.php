<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ReceiverController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

//            $data = Receiver::latest()->get();
            $user_id = Auth::id();
            $data = Receiver::latest()->where('user_id', $user_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editReceiver">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteReceiver">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('receivers');
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
        Receiver::updateOrCreate([
            'id' => $request->receiver_id
        ],
            [
                'name' => $request->name,
                'hvhh' => $request->hvhh,
                'user_id' => $user_id,
                'address' => $request->address


            ]);

        return response()->json(['success'=>'Receiver saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\Response
     */
    public function show(Receiver $receiver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $receiver = Receiver::find($id);
        return response()->json($receiver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receiver $receiver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Receiver::find($id)->delete();

        return response()->json(['success'=>'Receiver deleted successfully.']);
    }
}
