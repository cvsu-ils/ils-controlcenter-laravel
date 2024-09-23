<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTypes extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function notifications()
    {
        return $this->hasMany(Notifications::class, 'notifications_type_id');
    }
}
