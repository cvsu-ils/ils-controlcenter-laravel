<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AccessManagementPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessManagementPermissions extends Model
{
    protected $table = 'access_management_permissions';
    protected $fillable = ['name', 'description', 'guard_name'];
}

