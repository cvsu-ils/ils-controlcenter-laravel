<?php

namespace App\Http\Controllers;
use App\Models\InHouseLogs;
use Illuminate\Http\Request;

use App\Models\InHouseClassifications;
use Symfony\Component\HttpFoundation\Response;

class InHouseLogsController extends Controller
{

    public function index()
    {
        return view('inhouse');
    }

    public function chartInfo(){
        $apiController = new APIController();
        $url = 'http://library.cvsu.edu.ph/sandbox/laravel/api/inhouse';
        $data = $apiController->request('get', $url);

        return response()->json($data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|numeric',
            'quantity' => 'required|numeric',  
            'userId' => 'required',
            'location' => 'required',
            'parameter' => ''        
        ]);

        $apiController = new APIController();
        $data = $apiController->request('post', 'http://library.cvsu.edu.ph/sandbox/laravel/api/inhouse', [
            'classification_id' => request('class_id'),
            'qty' => request('quantity'),
            'location' => request('location'),
            'user_id' => request('userId'),
            'parameter' =>request('parameter'),
            
        ]);
        
        $data = [
            'status' => 'success',
            'title' => $data['message'],
            'message' => $data['message']
        ];

        return response()->json($data, Response::HTTP_OK);

    }
  
    public function show($id)
    {
        $record = InHouseClassifications::find($id);
        return view('cvsu-ils-inhouse.records', compact('classification'));
    }

}
