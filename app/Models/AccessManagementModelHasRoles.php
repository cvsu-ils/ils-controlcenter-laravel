<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessManagementModelHasRoles extends Model
{
    protected $table = 'access_management_model_has_roles';
    protected $fillable = ['role_id', 'model_id'];
}
