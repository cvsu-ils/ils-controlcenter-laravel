<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThesesFullText extends Model
{
    use HasFactory;

    protected $table = "ltx_theses_full_text";

    protected $fillable = [
        'filename', 'thesis_id', 'updated_by'
    ];
}
