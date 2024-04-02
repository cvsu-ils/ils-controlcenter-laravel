<?php

namespace App\Http\Controllers;
use App\Models\InHouseLogs;
use App\Models\InHouseClassifications;

use Illuminate\Http\Request;

class InHouseLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cvsu-ils-inhouse.records');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('cvsu-ils-inhouse.records')->with('classification', Classification::all());;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|numeric',
            'quantity' => 'required|numeric',  
            'userId' => 'required',
            'location' => 'required'        
        ]);
        $data = request()->all();
        $inhouselogs = new InHouseLogs();
        $inhouselogs->in_house_class_id = $data['class_id'];
        $inhouselogs->qty = $data['quantity'];
        $inhouselogs->updated_by = $data['userId'];
        $inhouselogs->location = $data['location'] . " Floor";

        $inhouselogs->save();

        $success = true;
        $message = "Added Successfully";

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = InHouseClassifications::find($id);
        return view('cvsu-ils-inhouse.records', compact('classification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
