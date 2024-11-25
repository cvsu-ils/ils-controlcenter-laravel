<?php

namespace App\Models\LTX;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'ltx_authors';

    protected $fillable = ['name', 'type', 'thesis_id'];
}
