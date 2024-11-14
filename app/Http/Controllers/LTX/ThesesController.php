<?php

namespace App\Http\Controllers\LTX;

use App\Models\Ranges;
use App\Models\Theses;
use App\Models\LCClass;
use App\Models\Programs;
use App\Models\ItemTypes;
use App\Models\LCSubClass;
use Illuminate\Support\Str;
use App\Models\SubjectCodes;
use Illuminate\Http\Request;
use App\Models\ThesisAuthors;
use App\Models\ThesesFullText;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ThesesController extends Controller
{
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
            'encodedByID' => 'required',
            'subjects' => 'required',
            'collaborators' => 'required',
            'bookCover' => 'nullable'
        ]);
        
        // if (!empty($data['bookCover'])) {
        //     $thesis_cover = $data['bookCover'];
        //     //$extension = explode('/', explode(':', substr($thesis_cover, 0, strpos($thesis_cover, ';')))[1])[1];  
            
        //     $replace = substr($thesis_cover, 0, strpos($thesis_cover, ',')+1); 

        //     $image = str_replace($replace, '', $thesis_cover); 

        //     $image = str_replace(' ', '+', $image); 

        //     $imageName = Str::slug($data['title'], '-') . '.jpg';

        //     Storage::disk('public')->put('thesis_cover/' .$imageName, base64_decode($image));
    
        //     $data['bookCover'] = $imageName;
        // }
        // else{
        //     $data['bookCover'] = null;        }
      
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
        //$thesis->opac_link = $data['link'];
        //$thesis->cover_filename = $data['bookCover'];
        $thesis->created_by = $data['encodedByID'];
        
        if ($thesis->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thesis created successfully.',
                'thesis_id' => $thesis->id,
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create thesis.'
            ], 500);
        }

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

        $adviser = ThesisAuthors::where('thesis_id', $thesis->id)->where('type' , 'adviser')->first();

        $classes = LCClass::all();

        $item_types = ItemTypes::all();
        $programs = Programs::all();
        $subject_codes = SubjectCodes::all(); 
        return view('ltx.edit', compact('thesis','classes', 'item_types','programs','subject_codes','id', 'classId','subclass','adviser'));
    }

    public function publishThesis($id)
    {
        $thesis = Theses::find($id);

        if ($thesis){
            
            $thesis->is_published = 1;
            $thesis->published_at =  now();          
            $thesis->save();

            return response()->json([
                'success'=> true,
                'status' => 'success',
                'message' => 'Thesis has been published',
            ]);
        }else{

            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Thesis not found',
            ]);
        }  
    }
    public function fullTextStore(Request $request){

        

        $data = $request->validate([
            'full_text' => 'required|file|mimes:pdf',
            'thesis_id' =>'required|integer',
        ]);

        if ($request->hasFile('full_text') && $request->file('full_text')->isValid()) {

            $randomFilename = Str::random(20) . '.pdf';
            
            //$filePath = $request->file('full_text')->storeAs('ltx_files',  $randomFilename);

            Storage::disk('ltx_files')->put($randomFilename, $request->file('full_text'));

            $full_text = new ThesesFullText();
            $full_text->filename = $randomFilename;
            $full_text->thesis_id = $data['thesis_id'];
            $full_text->updated_by = Auth::id();


            if ($full_text->save()) {

            dd([
                'status' => 'success',
                'message' => 'Thesis created successfully.',
            ]);
        } else {
            dd([
                'status' => 'error',
                'message' => 'Failed to create thesis.'
            ]);
        }

        }

    }
}
