<?php

namespace App\Models\LTX;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'ltx_subjects';

    protected $fillable = ['name', 'thesis_id'];
}
