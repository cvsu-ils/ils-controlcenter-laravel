<?php

namespace App\Http\Controllers\LTX;

use App\Models\Ranges;
use App\Models\Theses;
use App\Models\LCClass;
use App\Models\Programs;
use App\Models\Subjects;
use App\Models\ItemTypes;
use App\Models\LCSubClass;
use Illuminate\Support\Str;
use App\Models\SubjectCodes;
use Illuminate\Http\Request;
use App\Models\ThesisAuthors;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $length = $request->get('length', 20);

        $items = DB::table('ltx_theses')
        ->leftJoin('ltx_authors', 'ltx_theses.id', '=', 'ltx_authors.thesis_id')
        ->select(
            'ltx_theses.id',
            'ltx_theses.accession_number',
            'ltx_theses.title',
            'ltx_theses.year',
            DB::raw('GROUP_CONCAT(ltx_authors.name ORDER BY ltx_authors.id SEPARATOR "|") AS authors'),
            DB::raw('GROUP_CONCAT(ltx_authors.type ORDER BY ltx_authors.id SEPARATOR "^") AS types')
        )
        ->groupBy('ltx_theses.id', 'ltx_theses.accession_number', 'ltx_theses.title', 'ltx_theses.year')
        ->where('active', 1);

        if($filter == 'published'){
            $items->where('is_published', 1);
        }
        elseif($filter == 'unpublished'){
            $items->where('is_published', 0);
        }

        $data = $items->paginate($length);
        
        return view('ltx.catalog.index', compact('data', 'filter'));
    }

    public function archive(Request $request)
    {
        $length = $request->get('length', 20);

        $items = DB::table('ltx_theses')
        ->leftJoin('ltx_authors', 'ltx_theses.id', '=', 'ltx_authors.thesis_id')
        ->select(
            'ltx_theses.id',
            'ltx_theses.accession_number',
            'ltx_theses.title',
            'ltx_theses.year',
            DB::raw('GROUP_CONCAT(ltx_authors.name ORDER BY ltx_authors.id SEPARATOR "|") AS authors'),
            DB::raw('GROUP_CONCAT(ltx_authors.type ORDER BY ltx_authors.id SEPARATOR "^") AS types')
        )
        ->groupBy('ltx_theses.id', 'ltx_theses.accession_number', 'ltx_theses.title', 'ltx_theses.year')
        ->where('active', 0);

        $data = $items->paginate($length);

        return view('ltx.catalog.archive', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
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

    /*Check if URL exist*/
    // public function checkUrl(Request $request)
    // {
    //     $url = $request->input('url');

    //     return $this->checkUrlExists($url);
    // }

    
    // function checkUrlExists($url)
    // {
    //     try {
    //         $response = Http::timeout(10)->get($url);
    //         $statusCode = $response->status();

    //         return response()->json([
    //             'success' => $response->successful(),
    //             'status' => 'success',
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'status' => 'failed',
    //         ]);
    //     }
    // }

   

}
