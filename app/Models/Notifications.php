<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
     use HasFactory;
     protected $fillable = ['user_id', 'message', 'notifications_type_id','has_read'];

     public function type()
     {
         return $this->belongsTo(NotificationTypes::class, 'notifications_type_id');
     }

}
