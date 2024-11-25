<?php

namespace App\Observers\LTX;

use App\Models\LTX\Theses;
use App\Models\LTX\Cover;

class CoverObserver
{
    public function created(Cover $cover)
    {
        $thesis = Theses::find($cover->thesis_id);
        $thesis->cover_id = $cover->id;
        $thesis->cover_filename = $cover->filename;
        $thesis->save();       
    }
}
