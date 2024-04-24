<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CollectionsCount;

class CollectionsController extends Controller
{
    public function getData(Request $request, $selectedKeyCollections)
    {
        $endpoints = [
            'e-books' => 'http://library.cvsu.edu.ph/sandbox/laravel/api/dashboard/ebooks/openaccess',
            'e-theses' => 'http://library.cvsu.edu.ph/sandbox/laravel/api/dashboard/etheses',
            'e-journals' => 'http://library.cvsu.edu.ph/sandbox/laravel/api/dashboard/ejournals/openaccess'




        ];

        if (!isset($endpoints[$selectedKeyCollections])) {
            return response()->json(['error' => 'Invalid collection selected'], Response::HTTP_BAD_REQUEST);
        }

        $apiController = new APIController();   
        $data = $apiController->request('get', $endpoints[$selectedKeyCollections]);

        return response()->json($data, Response::HTTP_OK);
    }

}
        // $data = CollectionsCount::where('book_type', $selectedKeyCollections)->count();

        // if ($data !== null) {
        //     return $data;
        // } else {
        //     return ['error' => 'Data not found'];
        // }

                    // 'e-theses' => 'http://library.cvsu.edu.ph/sandbox/laravel/api/dashboard/etheses/openaccess',
            // 'e-journals' => 'http://library.cvsu.edu.ph/sandbox/laravel/api/dashboard/ejournals/openaccess'