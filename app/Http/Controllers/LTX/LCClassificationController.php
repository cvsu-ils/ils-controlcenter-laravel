<?php

namespace App\Http\Controllers\LTX;

use App\Models\Ranges;
use App\Models\LCClass;
use App\Models\LCSubClass;
use App\Models\LTX\Program;
use App\Models\LTX\ItemType;
use Illuminate\Http\Request;
use App\Models\LTX\SubjectCode;
use App\Http\Controllers\Controller;

class LCClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = LCClass::all();
        $item_types = ItemType::all();
        $programs = Program::all();
        $subject_codes = SubjectCode::all(); 
     
        return view('ltx.create',compact('classes', 'item_types','programs','subject_codes'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubClass(Request $request)
    {
        $class_id = $request->input('classid');

        $sub_class = LCSubClass::where('class_id', $class_id)->get();

        $response = [
            'data' => $sub_class,
            'status' => 'success',
            
        ];
        return response()->json($response);
    }

    public function getRange(Request $request)
    {
        $subclass_id = $request->input('subclassid');

        $ranges = Ranges::where('subclass_id', $subclass_id)->get();

        return response()->json([
            'data' => $ranges,
            'status' => 'success',     
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
