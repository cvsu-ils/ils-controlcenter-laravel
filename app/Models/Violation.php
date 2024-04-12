<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $table = 'violations';
    protected $fillable = ['card_number', 'violation_desc', 'violation_type', 'dateEnded', 'remarks'];
    
}
