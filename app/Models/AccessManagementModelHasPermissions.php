<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessManagementModelHasPermissions extends Model
{
    protected $table = 'access_management_model_has_permissions';
    protected $fillable = ['permission_id', 'model_id'];
}
