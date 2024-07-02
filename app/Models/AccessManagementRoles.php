<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessManagementRoles extends Model
{
    protected $table = 'access_management_roles';
    protected $fillable = ['name', 'guard_name'];
}
