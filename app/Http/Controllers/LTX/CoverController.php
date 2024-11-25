<?php

namespace App\Http\Controllers\LTX;

use Illuminate\Support\Str;
use App\Models\LTX\Cover;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CoverController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'file' => 'required|image',
            'thesis_id' => 'required|int',
            'updated_by' => 'required|int'
        ]);

        $uploadedFile = $request->file('file');
        $originalExtension = $uploadedFile->getClientOriginalExtension();
        
        $uploadedFile = file_get_contents($uploadedFile);

        $fileName = 'em-' . $data['thesis_id'] .  "-" . time(). '.jpg';


        if (strtolower($originalExtension) != 'jpg') {
            $uploadedFile = Image::make($uploadedFile)->encode('jpg');
        }

        Storage::disk('public')->put($fileName, $uploadedFile);

        $cover = new Cover();
        $cover->filename = $fileName;
        $cover->thesis_id = $data['thesis_id'];
        $cover->updated_by = $data['updated_by'];

        if(!$cover->save()) {
            return response()->json([
                'error' => 'The uploaded file must be an image.',
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'message' => 'Image uploaded and stored successfully.',
        ]);

    }
}
