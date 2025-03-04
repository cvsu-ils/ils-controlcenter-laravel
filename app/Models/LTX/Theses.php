<?php

namespace App\Models\LTX;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theses extends Model
{
    use HasFactory;

    protected $table = 'ltx_theses';

    public function authors()
    {
        return $this->hasMany(Author::class, 'thesis_id');
    }

    protected $fillable = 
        ['item_type_id', 'language', 'subject_code_id','program_id', 
        'title', 'publication_place', 'publisher', 'year', 'pages', 
        'physical_description','general_notes','bibliography', 'summary', 'table_of_contents',
        'range', 'cutter_ending', 'submitted_id','full_text_id', 'cover_id', 'cover_filename', 
        'is_published','published_at','created_by',
        ];
    
    
    public static function getTheses($filter, $length)
    {
        $query = self::with('authors')
            ->select('id', 'accession_number', 'title', 'year')
            ->where('active', 1);

        if ($filter == 'published') {
            $query->where('is_published', 1);
        } elseif ($filter == 'unpublished') {
            $query->where('is_published', 0);
        }

        $theses = $query->paginate($length);

        return $theses;
    }

    public static function getArchive($length)
    {
        $query = self::with('authors')
            ->select('id', 'accession_number', 'title', 'year')
            ->where('active', 0);

        $theses = $query->paginate($length);

        return $theses;
    }
}