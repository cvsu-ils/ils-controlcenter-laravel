<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\APIController;
use App\Http\Controllers\FormController;

class FormController extends Controller
{

    public function index()
    {
        return view('form');
    }

    public function quicklog()
    {
        $violationsList = Violation::all();
        return view('quicklog')->with('violationsList', $violationsList);
    }

    public function showForm(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $filterCriteria = $request->filter_criteria ?? 'all';
        $search = $request->search ?? null;

        $violations = Violation::query()
            ->when($search, function($query) use ($search) {
                $query->where('card_number', 'LIKE', "%{$search}%");
            })
            ->when($filterCriteria != 'all', function($query) use ($filterCriteria, $today) {
                if($filterCriteria == 'cleared') {
                    $query->where('dateEnded', '<', $today)
                        ->whereNull('remarks')
                        ->orWhere(function ($query) {
                            $query->where('remarks', 1)
                                ->whereNull('dateEnded');
                        });
                } else if($filterCriteria == 'ongoing') {
                    $query->where('dateEnded', '>', $today)
                        ->whereNull('remarks')
                        ->orWhere(function ($query) {
                            $query->where('remarks', 0)
                                ->whereNull('dateEnded');
                        });
                }
            })
            ->get();

        return view('index')->with([
            'violations' =>  $violations,
            'today' => $today,
            'search' => $search,
            'filterCriteria' => $filterCriteria
        ]);       
        
    }

    public function store(Request $request)
    {    
        $max_length = 9;
        $violations = new Violation();
        if (strlen($violations->card_number) <= $max_length) {
            $violations->card_number = $request->cardnum;
        }
        
        $violations->violation_desc = $request->violation_desc;
        $violations->violation_type = $request->violation_type;
        if ($violations->violation_type=="Duration") {
            $violations->dateEnded = $request->dateEnded;
        }
        if ($violations->violation_type=="Accomplishment") {
            $violations->remarks = $request->remarks;
        }
        
        $violations->save();
        return view('form');
    }

    public function receipt(Request $request)
    {
        $violations = new Violation();
        $violations->card_number = $request->cardnum;
    
        $today = Carbon::today()->toDateString();
    
        $sanctionAccom = $violations->where('cardnum', $request->cardnum)->first();
    
        if ($sanctionAccom) {
            return view('receipt')->with([
                'sanctionAccom' => $sanctionAccom,
                'violations' => $violations,
                'today' => $today
            ]);
        } else{
            echo "<script>alert('Welcome to CvSU Library!');</script>";
        }
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

    public function filter(Request $request)
    {
        $filterCriteria = $request->input('filter_criteria');
        $today = Carbon::today()->toDateString();

        $violations = Violation::query();
    
        

        $violations = $violations->get();

        return view('index', compact('violations', 'today'));
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
        $input = request('card_number');

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