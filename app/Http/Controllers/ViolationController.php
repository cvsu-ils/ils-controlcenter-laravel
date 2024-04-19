<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\APIController;
use App\Http\Controllers\ViolationController;

class ViolationController extends Controller
{

    public function index()
    {
        return view('violationList');
    }

    public function showForm(Request $request)
    {
        $today = now()->toDateString();
        $filterCriteria = $request->filter ?? 'all';
        $search = $request->search ?? null;

        $queryStrings = [];
        $queryStrings['filter'] = $filterCriteria;

        if($search) {
            $queryStrings['search'] = $search;
        }

        // echo 'http://library.cvsu.edu.ph/sandbox/laravel/api/violations' . $queryString;
    
        $validation = new APIController();
        $list = $validation->request('get', 'http://library.cvsu.edu.ph/sandbox/laravel/api/violations', $queryStrings);
    
        $data = $list['data'];

        // dd($data);
       
        // if ($search) {
        //     $data = array_filter($data, function($item) use ($search) {
        //         return strpos($item['card_number'], $search) !== false;
        //     });
        // }

        // if ($filterCriteria != 'all') {
        //     $data = array_filter($data, function($item) use ($today, $filterCriteria) {
        //         if ($filterCriteria == 'cleared') {
        //             return ($item['date_ended'] > $today && $item['status'] == 0) || is_null($item['date_ended']);
        //         } elseif ($filterCriteria == 'ongoing') {
        //             return ($item['date_ended'] < $today && $item['status'] == 1);
        //         }
        //         return true;
        //     });
        // }    
    
        return view('violationList')->with([
            'violations' => $data,
            'today' => $today,
            'search' => $search,
            'filterCriteria' => $filterCriteria
        ]);
    }
    
    


    public function store(Request $request)
    {
        $request->validate([
            'cardnum' => 'required|digits:9|numeric',
            'violation_desc' => 'required',
            'dateEnded' => [
                'required_if:violation_type,Duration',
            ],
            'remarks' => [
                'required_if:violation_type,Accomplishment',
            ],
        ]);

        // $violations = new Violation();

        // if (strlen($violations->card_number) <= $max_length) {
        //     $violations->card_number = $request->cardnum;
        // }
        
        // $violations->violation_desc = $request->violation_desc;
        // $violations->violation_type = $request->violation_type;

        // if ($violations->violation_type=="Duration") {
        //     $violations->dateEnded = $request->dateEnded;
        // }
        // if ($violations->violation_type=="Accomplishment") {
        //     $violations->remarks = $request->remarks;
        // }

        

        $validation = new APIController();
        $data = $validation->request('post', 'http://library.cvsu.edu.ph/sandbox/laravel/api/violations', [

            'card_number' => request('cardnum'),
            'description' => request('violation_desc'),
            'type' => request('violation_type'),
            'date_ended' => request('dateEnded'),
            'status' => request('remarks'),
            'user_id' => auth()->user()->id
        ]);
        $data = [
            'status' => 'success',
            'title' => $data['message'],
            'message' => $data['message']
        ];

        // $violations->save();
        return response()->json($data, Response::HTTP_OK);
    }
    
    
    public function edit(int $selectedId)
    {
        Violation::where([
            ['id', $selectedId],
            ['violation_type', 'Accomplishment']
        ])->update([
            'remarks' => 1
        ]);
        
        return redirect()->back();
    }

    public function validation($cardnumber)
    {
        $validation = new APIController();
        $data = $validation->request('get', 'http://library.cvsu.edu.ph/sandbox/laravel/api/patrons/' . $cardnumber);

        if($data) {
            if ($data['statusCode'] == 404) {
                return false;
            } else {
                return $data;
            }
        }

        return false;
    }

    public function findPatron(Request $request)
    {
        $input = request('cardNumber');

        $data = $this->validation($input);

        if(!$data) {
            return response()->json([
                'status' => 'error',
                'title' => "Patron not found!",
                'message' => "Patron need to be registered!"
            ],
                Response::HTTP_OK
            );
        }

        return response()->json($data, Response::HTTP_OK);
    }

}