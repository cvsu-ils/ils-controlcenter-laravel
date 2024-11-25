<?php

namespace App\Observers\LTX;

use App\Models\LTX\Theses;
use App\Models\LTX\FullText;

class FullTextObserver
{
    public function created(FullText $full_text)
    {
        $thesis = Theses::find($full_text->thesis_id);
        $thesis->full_text_id = $full_text->id;
        $thesis->save();      
    }
}
