<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessManagementRoleHasPermissions extends Model
{
    protected $table = 'access_management_role_has_permissions';
    protected $fillable = ['permission_id', 'role_id'];
}
