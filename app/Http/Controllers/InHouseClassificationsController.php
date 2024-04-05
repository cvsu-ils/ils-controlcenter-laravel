<?php

namespace App\Http\Controllers;
use App\Models\InHouseClassifications;
use Symfony\Component\HttpFoundation\Response;



use Illuminate\Http\Request;

class InHouseClassificationsController extends Controller
{
    public function class()
    {
        $apiController = new APIController();
        $url = 'http://library.cvsu.edu.ph/sandbox/laravel/api/inhouse/classification';
        $response = $apiController->request('get', $url);
     
        return view('inhouse-classification')->with('classification', $response);
    }

    public function editView()
    {
        $apiController = new APIController();
        $url = 'http://library.cvsu.edu.ph/sandbox/laravel/api/inhouse/classification';
        $response = $apiController->request('get', $url);

        return view('inhouse-edit')->with('classification',$response);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'alphabetic_range' => 'required',
            'numeric_range_from' => 'required|numeric',
            'numeric_range_to' => 'required|numeric',
            'user_id' => 'required|numeric'
            
        ]);

        $apiController = new APIController();
        $data = $apiController->request('post', 'http://library.cvsu.edu.ph/sandbox/laravel/api/inhouse/classification', [
            'name' => request('name'),
            'alphabetic_range' => request('alphabetic_range'),
            'numeric_range_from' => request('numeric_range_from'),
            'numeric_range_to' => request('numeric_range_to'),
            'user_id' => request('user_id')
            
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
        $classification = InHouseClassifications::findOrFail($id);

        return response()->json([
            'id' => $classification->id,
            'class_name' => $classification->class_name,
            // Include other relevant data as needed
        ]);
    }

    public function edit($id)
    {

        $apiController = new APIController();
        $url = 'http://library.cvsu.edu.ph/sandbox/laravel/api/inhouse/classification/' . $id;
        $response = $apiController->request('get', $url,[
            'name' => request('name'),
            'alphabetic_range' => request('alphabetic_range'),
            'numeric_range_from' => request('numeric_range_from'),
            'numeric_range_to' => request('numeric_range_to'),
            'user_id' => request('user_id')         
        ]);

        if (!$response || !is_array($response) || !array_key_exists('data', $response)) {
            return response()->json(['message' => 'Invalid data received from API'], 500);
        }      
        $data = $response['data'];

        // Extract numeric range (if available)
    
        $combined = $data['numeric_range'];
        $delimiter = "-";
        $number = explode($delimiter,$combined);
        [$numeric_range_from, $numeric_range_to] = $number;

        return response()->json([
            'id' => $data['id'],
            'name' => $data['name'],
            'alphabetic_range' => $data['alphabetic_range'],
            'numeric_range_from' => $numeric_range_from,
            'numeric_range_to' => $numeric_range_to,
        ]);
    }

    public function update(Request $request, $id)
    
    {   
        $data = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'alphabetic_range' => 'required',
            'numeric_range_from' => 'required|numeric',
            'numeric_range_to' => 'required|numeric',
            'user_id' => 'required|numeric'
        ]);
        $apiController = new APIController();       
        $data = $apiController->request('patch', 'http://library.cvsu.edu.ph/sandbox/laravel/api/inhouse/classification/'. $id,[
            'id' => $id,
            'name' => request('name'),
            'alphabetic_range' => request('alphabetic_range'),
            'numeric_range_from' => request('numeric_range_from'),
            'numeric_range_to' =>request('numeric_range_to'),
            'user_id' => request('user_id')         
        ]); 
        

       

        $data = [
            'status' => 'success',
            'title' => $data['message'],
            'message' => $data['message']
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
