<?php

namespace App\Http\Controllers;
use App\Models\InHouseClassifications;


use Illuminate\Http\Request;

class InHouseClassificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inhouse')->with('classification', InHouseClassifications::all());
    }

    public function editView()
    {
        return view('inhouse-edit')->with('classification', InHouseClassifications::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('cvsu-ils-inhouse.class');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'class_name' => 'required',
            'alphabetic_range' => 'required',
            'numeric_range_from' => 'required|numeric',
            'numeric_range_to' => 'required|numeric',
            
        ]);

        $data = request()->all();
        $classification = new InHouseClassifications();
        $classification->class_name = $data['class_name'];
        $classification->alphabetic_range = $data['alphabetic_range'];
        $num1  = $data['numeric_range_from'];
        $num2 = $data['numeric_range_to'];
        $combine = implode('-', [$num1, $num2]);
        $classification->numeric_range = $combine;
        $classification->updated_by = 12;
        $classification->save();

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
        $classification = InHouseClassifications::findOrFail($id);

        return response()->json([
            'id' => $classification->id,
            'class_name' => $classification->class_name,
            // Include other relevant data as needed
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    
 
    public function edit($id)
    {
        $classification = InHouseClassifications::findOrFail($id);


        $combined = $classification->numeric_range;
        $delimiter = "-";
        $data = explode($delimiter,$combined);
        [$data1, $data2] = $data;

        return response()->json([
            'id' => $classification->id,
            'class_name' => $classification->class_name,
            'alphabetic_range' => $classification->alphabetic_range,
            'numeric_range_from' => $data1,
            'numeric_range_to' => $data2
            // Include other relevant data as needed
        ]);
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
        $data = $request->validate([
            'id' => 'required',
            'class_name' => 'required',
            'alphabetic_range' => 'required',
            'numeric_range_from' => 'required|numeric',
            'numeric_range_to' => 'required|numeric',
            
        ]);
        $data = request()->all();
        $classification = InHouseClassifications::find($id);
        $classification->class_name = $data['class_name'];
        $classification->id = $data['id'];
        $classification->alphabetic_range = $data['alphabetic_range'];
        $num1  = $data['numeric_range_from'];
        $num2 = $data['numeric_range_to'];
        $combine = implode('-', [$num1, $num2]);
        $classification->numeric_range = $combine;
        $classification->updated_by = 2;

        $classification->save();

        $success = true;
        $message = "Updated Successfully";

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
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
