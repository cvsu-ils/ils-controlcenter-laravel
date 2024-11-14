<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThesesCovers extends Model
{
    use HasFactory;

    protected $table = 'ltx_theses_covers';

    protected $fillable = ['cover_filename', 'thesis_id', 'updated_by'];
}
