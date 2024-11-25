<?php

namespace App\Http\Controllers\LTX;

use Illuminate\Support\Str;
use App\Models\LTX\FullText;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FullTextController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_text' => 'required|file|mimes:pdf',
            'thesis_id' =>'required|integer',
        ]);

        if ($request->hasFile('full_text') && $request->file('full_text')->isValid()) {

            $filename = 'em-' . $data['thesis_id'] .  "-" . time(). '.pdf';

            Storage::disk('ltx_files')->put($filename, $request->file('full_text')->getContent());

            $full_text = new FullText();
            $full_text->filename = $filename;
            $full_text->thesis_id = $data['thesis_id'];
            $full_text->updated_by = auth()->user()->id;

            if (!$full_text->save()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create thesis.'
                ]);        
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Thesis created successfully.',
            ]);
        }
    }
}
