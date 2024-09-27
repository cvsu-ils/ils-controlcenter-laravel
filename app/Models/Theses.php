<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theses extends Model
{
    use HasFactory;

    protected $table = 'ltx_theses';

    protected $fillable = ['itemType', 'language', 'subjectCode','program', 
    'title', 'publicationPlace', 'publisher', 'year', 'pages', 
    'physicalDescription','generalNotes','bibliography', 'summary', 'tableOfContents',
    'range', 'endings', 'link', 'encodedByID', 'subjects', 'collaborators', 'bookCover'
];
}