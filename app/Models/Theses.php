<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theses extends Model
{
    use HasFactory;

    protected $table = 'ltx_theses';

    protected $fillable = ['item_type_id', 'language', 'subject_code_id','program_id', 
    'title', 'publication_place', 'publisher', 'year', 'pages', 
    'physical_description','general_notes','bibliography', 'summary', 'table_of_contents',
    'range', 'cutter_ending', 'submitted_id','full_text_id', 'cover_id', 'cover_filename', 
    'is_published','published_at','created_by',
];
}