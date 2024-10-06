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

        $length = $request->get('length', 20); // Default pagination length
        $data = DB::table('ltx_theses')
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
    ->paginate($length);
    
        return view('ltx.catalog.index', compact('data'));
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'itemType' => 'required',
            'language' => 'required',
            'subjectCode' => 'required',
            'program' => 'required',
            'title' => 'required',
            'publicationPlace' => 'required',
            'publisher' => 'required',
            'year' => 'required|numeric',
            'pages' => 'required|numeric',
            'physicalDescription' => 'nullable',
            'generalNotes' => 'nullable',
            'bibliography' => 'nullable',
            'summary' => 'nullable',
            'tableOfContents' => 'nullable',
            'range' => 'required',
            'endings' => 'required',
            'link' => 'required',
            'encodedByID' => 'required',
            'subjects' => 'required',
            'collaborators' => 'required',
            'bookCover' => 'required'
        ]);
        
        if (!empty($data['bookCover'])) {
            $thesis_cover = $data['bookCover'];
            //$extension = explode('/', explode(':', substr($thesis_cover, 0, strpos($thesis_cover, ';')))[1])[1];  
            
            $replace = substr($thesis_cover, 0, strpos($thesis_cover, ',')+1); 

            $image = str_replace($replace, '', $thesis_cover); 

            $image = str_replace(' ', '+', $image); 

            $imageName = Str::slug($data['title'], '-') . '.jpg';

            Storage::disk('public')->put('thesis_cover/' .$imageName, base64_decode($image));
    
            $data['bookCover'] = $imageName;
        }
      
        $thesis = new Theses();
        $thesis->item_type_id = $data['itemType'];
        $thesis->language = $data['language'];
        $thesis->subject_code_id = $data['subjectCode'];
        $thesis->program_id = $data['program'];
        $thesis->title = $data['title'];
        $thesis->year = $data['year'];
        $thesis->pages = $data['pages'];
        $thesis->publication_place = $data['publicationPlace'];
        $thesis->publisher = $data['publisher'];
        $thesis->physical_description = $data['physicalDescription'];
        $thesis->general_notes = $data['generalNotes'];
        $thesis->bibliography = $data['bibliography'];
        $thesis->summary = $data['summary'];
        $thesis->table_of_contents = $data['tableOfContents'];
        $thesis->range = $data['range'];
        $thesis->cutter_ending = $data['endings'];
        $thesis->opac_link = $data['link'];
        $thesis->cover = $data['bookCover'];
        $thesis->created_by = $data['encodedByID'];
        
        if ($thesis->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thesis created successfully.',
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create thesis.'
            ], 500);
        }

    }

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thesis = Theses::find($id);
        $subclass = Ranges::where('id', $thesis->range)->first()->subclass_id;

        $classId = LCSubClass::where('id', $subclass)->first()->class_id;

        $classes = LCClass::all();

        $item_types = ItemTypes::all();
        $programs = Programs::all();
        $subject_codes = SubjectCodes::all(); 
        return view('ltx.edit', compact('thesis','classes', 'item_types','programs','subject_codes','id', 'classId','subclass'));
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
    public function checkUrl(Request $request)
    {
        $url = $request->input('url');

        return $this->checkUrlExists($url);
    }

    
    function checkUrlExists($url)
    {
        try {
            $response = Http::timeout(10)->get($url);
            $statusCode = $response->status();

            return response()->json([
                'success' => $response->successful(),
                'status' => 'success',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'failed',
            ]);
        }
    }

   

}
