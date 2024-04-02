<?php

namespace App\Http\Controllers;

use App\Models\WifiLogs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use stdClass;

class WifiLogsController extends Controller
{

    public function validation($cardnumber)
    {
        // GET http://library.cvsu.edu.ph/sandbox/laravel/api/patrons/{cardnumber}

        $validation = new APIController();
        $data = $validation->request('get', 'http://library.cvsu.edu.ph/sandbox/laravel/api/patrons/' . $cardnumber);

        if($data) {
            if ($data['statusCode'] == 404) {
                return 0;
            } else {
                if($data['data']['isExpired']) {
                    return 1;
                }
            }
        }
        return 2;
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'cardnum' => 'required|digits:9|numeric', 
            'location' => 'required', 
        ]);
        
        
        // validation cardnum. if validated continue
        // $validated = $request->validated();

        // $validated = $request->safe()->only(['cardnum']);
        // return response()->json($data, Response::HTTP_OK);

        switch($this->validation(request('cardnum'))) {
            case 0:
                return response()->json([
                    'status' => 'error',
                    'title' => "Patron not found!",
                    'message' => "Patron need to be registered!"
                ],
                    Response::HTTP_OK
                );
                break;
            case 1:
                return response()->json([
                    'status' => 'info',
                    'title' => "Patron account is expired!",
                    'message' => "Patron need to be validated!"
                ],
                    Response::HTTP_OK
                );
                break;
        }

        $apiController = new APIController();
        $data = $apiController->request('post', 'http://library.cvsu.edu.ph/sandbox/laravel/api/wifilogs', [
            'cardnumber' => request('cardnum'),
            'location' => request('location'),
            'user_id' => request('userId')
        ]);

        // $data = request()->all();
        // $logging_sys = new WifiLogs();
        // $logging_sys->cardnum = $data['cardnum'];
        // $logging_sys->userId = 1; 
        // $logging_sys->location = $data['location'];
        // $logging_sys->save();

        $data = [
            'status' => 'success',
            'title' => $data['message'],
            'message' => $data['message']
        ];

        return response()->json($data, Response::HTTP_OK);

    }
}
