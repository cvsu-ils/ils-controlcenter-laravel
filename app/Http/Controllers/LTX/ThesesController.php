<?php

namespace App\Http\Controllers\LTX;

use App\Models\Ranges;
use App\Models\LCClass;
use App\Models\LTX\Cover;
use App\Models\LCSubClass;
use App\Models\LTX\Author;
use App\Models\LTX\Theses;
use App\Models\LTX\Program;
use App\Models\LTX\FullText;
use App\Models\LTX\ItemType;
use Illuminate\Http\Request;
use App\Models\LTX\SubjectCode;
use App\Http\Controllers\Controller;
use App\Services\AccessionNumberService;
use App\Http\Controllers\LTX\SubjectController;

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
        $thesis->created_by = $data['encodedByID'];
        
        if (!$thesis->save()) {    
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create thesis.'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thesis created successfully.',
            'thesis_id' => $thesis->id,
        ], 201);
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

        $adviser = Author::where('thesis_id', $thesis->id)->where('type' , 'adviser')->first();

        $classes = LCClass::all();

        $cover = Cover::where('thesis_id', $thesis->id)->latest()->first();

        $item_types = ItemType::all();
        $programs = Program::all();
        $subject_codes = SubjectCode::all(); 
        $full_texts = FullText::where('thesis_id', $thesis->id)->orderBy('created_at', 'desc')->get();

        return view('ltx.edit', compact('thesis','classes', 'item_types',
        'programs','subject_codes','id', 
        'classId','subclass','cover','full_texts','adviser'));
    }

    public function publish($id)
    {
        $thesis = Theses::find($id);
        if (!$thesis){
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'Thesis not found',
            ]);
        }

        $accessionNumberService = new AccessionNumberService();

        $thesis->is_published = 1;
        $thesis->published_at =  now();
        $thesis->accession_number = $accessionNumberService->generate('EM', $id);          
        $thesis->save();

        return response()->json([
            'success'=> true,
            'status' => 'success',
            'message' => 'Thesis has been published',
        ]);
    }

    public function update(Request $request, $id)
    {
        $thesis = Theses::find($id);

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
        ]);

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
        $thesis->created_by = $data['encodedByID'];

        if (!$thesis->save()) {
           return response()->json([
                'status' => 'error',
                'message' => 'Failed to create thesis.'
            ], 500);
        }

        $authorController = new AuthorController();
        $subjectController = new SubjectController();
        
        $authorController->update($thesis, $data['collaborators']);
        $subjectController->update($thesis, $data['subjects']);

        return response()->json([
            'status' => 'success',
            'message' => 'Thesis edited successfully.',
        ], 201);

    }
}
