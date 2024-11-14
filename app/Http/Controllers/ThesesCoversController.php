<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThesesCoversController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'cover_filename' => 'required',
            'thesis_id' => 'required',
            'updated_by' => 'required',
        ]);

        
        
        if (!empty($data['cover_filename'])) {
            $thesis_cover = $data['cover_filename'];
            //$extension = explode('/', explode(':', substr($thesis_cover, 0, strpos($thesis_cover, ';')))[1])[1];  
            
            $replace = substr($thesis_cover, 0, strpos($thesis_cover, ',')+1); 

            $image = str_replace($replace, '', $thesis_cover); 

            $image = str_replace(' ', '+', $image); 

            $imageName = Str::slug($data['title'], '-') . '.jpg';

            Storage::disk('public')->put('thesis_cover/' .$imageName, base64_decode($image));
    
            $data['cover_filename'] = $imageName;
        }
        
        dd($data['cover_filename']);
      
    //     $thesis = new Theses();
    //     $thesis->item_type_id = $data['itemType'];
    //     $thesis->language = $data['language'];
    //     $thesis->subject_code_id = $data['subjectCode'];
    //     $thesis->program_id = $data['program'];
    //     $thesis->title = $data['title'];
    //     $thesis->year = $data['year'];
    //     $thesis->pages = $data['pages'];
    //     $thesis->publication_place = $data['publicationPlace'];
    //     $thesis->publisher = $data['publisher'];
    //     $thesis->physical_description = $data['physicalDescription'];
    //     $thesis->general_notes = $data['generalNotes'];
    //     $thesis->bibliography = $data['bibliography'];
    //     $thesis->summary = $data['summary'];
    //     $thesis->table_of_contents = $data['tableOfContents'];
    //     $thesis->range = $data['range'];
    //     $thesis->cutter_ending = $data['endings'];
    //     //$thesis->opac_link = $data['link'];
    //     //$thesis->cover_filename = $data['bookCover'];
    //     $thesis->created_by = $data['encodedByID'];
        
    //     if ($thesis->save()) {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Thesis created successfully.',
    //             'thesis_id' => $thesis->id,
    //         ], 201);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to create thesis.'
    //         ], 500);
    //     }

    }
}
