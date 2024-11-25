<?php

namespace App\Models\LTX;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullText extends Model
{
    use HasFactory;

    protected $table = "ltx_theses_full_text";

    protected $fillable = [
        'filename', 'thesis_id', 'updated_by'
    ];
}
