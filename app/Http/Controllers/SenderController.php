<?php

namespace App\Http\Controllers;

use App\Models\Receiver;
use App\Models\Sender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SenderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

//            $data = Receiver::latest()->get();
            $user_id = Auth::id();
            $data = Sender::latest()->where('user_id', $user_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editSender">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteSender">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('senders');
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
        Sender::updateOrCreate([
            'id' => $request->sender_id
        ],
            [
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'user_id' => $user_id,
            ]);

        return response()->json(['success'=>'Sender saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sender  $sender
     * @return \Illuminate\Http\Response
     */
    public function show(Sender $sender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sender  $sender
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $sender = Sender::find($id);
        return response()->json($sender);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sender $sender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sender $sender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sender  $sender
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Sender::find($id)->delete();

        return response()->json(['success'=>'Sender deleted successfully.']);
    }
}
