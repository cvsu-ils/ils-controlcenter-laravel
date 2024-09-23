<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserInformation;
use Illuminate\Support\Facades\DB;

use App\Models\AccessManagementRoles;
use App\Models\AccessManagementPermissions;
use App\Models\AccessManagementModelHasRoles;
use App\Models\AccessManagementRoleHasPermissions;
use App\Models\AccessManagementModelHasPermissions;
use App\Http\Controllers\AccessManagementController;

class AccessManagementController extends Controller
{
    public function index(){

        $role = AccessManagementRoles::all();
        $permission = AccessManagementPermissions::all();  

        return view('access-management-index')
            ->with('roles', $role)
            ->with('permissions', $permission);
    }

    public function store(Request $request){

        $users = UserInformation::all();
        $role = AccessManagementRoles::all();
        $permission = AccessManagementPermissions::all();   
        
        $roleHasPermissions = AccessManagementRoleHasPermissions::all();   
        $modelHasPermissions = AccessManagementModelHasPermissions::all();   
        $modelHasRoles = AccessManagementModelHasRoles::all();   

        $search = $request->search ?? null;
    
        $userQuery = UserInformation::query()
            ->when($search, function($query) use ($search){
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'roles' => 'nullable|string',
                'permissions' => 'nullable|string',
            ]);
        
            $user = new UserInformation();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->save();
        
            $roles = array_filter(explode(',', $request->roles));
            $permissions = array_filter(explode(',', $request->permissions));
        
            if (!empty($roles)) {
                foreach ($roles as $roleId) {
                    $userRole = new AccessManagementModelHasRoles();
                    $userRole->model_id = $user->id; // assuming 'user_id' is renamed to 'model_id' in your ModelHasRoles table
                    $userRole->role_id = $roleId;
                    $userRole->save();
                }
            }
        
            if (!empty($permissions)) {
                foreach ($permissions as $permissionId) {
                    $userPermission = new AccessManagementModelHasPermissions();
                    $userPermission->model_id = $user->id; // assuming 'user_id' is renamed to 'model_id' in your ModelHasPermissions table
                    $userPermission->permission_id = $permissionId;
                    $userPermission->save();
                }
            }
        
            return response()->json(['success' => 'User information saved successfully.']);
    }

    public function user(Request $request)
    {    
        $users = UserInformation::all();
        $role = AccessManagementRoles::all();
        $permission = AccessManagementPermissions::all();   

        $search = $request->search ?? null;
    
        $userQuery = UserInformation::query()
            ->when($search, function($query) use ($search){
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('access-management-user')
            ->with('user', $userQuery)
            ->with('role', $role)
            ->with('permission', $permission)
            ->with('search', $search);
    }


    public function role(Request $request)
    {
        $permissions = AccessManagementPermissions::all();    

        $search = $request->search ?? null;
    
        $roles = AccessManagementRoles::query()
            ->when($search, function($query) use ($search){
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        $roleData = [];
    
        foreach ($roles as $role) {
            $role_has_permissions = AccessManagementRoleHasPermissions::where('role_id', $role->id)->get();
            
            $rolePermissions = [];
            foreach ($role_has_permissions as $role_permission) {
                $permission = $permissions->where('id', $role_permission->permission_id)->first();
                
                if ($permission) {
                    $rolePermissions[] = [
                        'name' => $permission->name,
                        'description' => $permission->description
                    ];
                }
            }
    
            $roleData[] = [
                'role' => $role,
                'permissions' => $rolePermissions
            ];
        }
    
        return view('access-management-role')->with('roleData', $roleData)->with('permissions', $permissions)->with('search', $search);
    }
    

    public function permission(Request $request)
    {
        $search = $request->search ?? null;
    
        $permissions = AccessManagementPermissions::query()
            ->when($search, function($query) use ($search){
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('access-management-permission')
            ->with('permission', $permissions)
            ->with('search', $search);
    }
    

    public function storePermission(Request $request)
    {
        $permission = new AccessManagementPermissions();
        
        $permission->name = $request->input('name');
        $permission->description = $request->input('description');
        $permission->guard_name = $request->input('guard_name');      
        $permission->save();

        return response()->json($permission, Response::HTTP_OK);
    }

    public function storeRole(Request $request)
    {
        $role = new AccessManagementRoles();
        $role->name = $request->input('name');
        $role->guard_name = $request->input('guard_name');
        $role->save();
    
        $permissions = $request->input('permissions_id', []);
    
        foreach ($permissions as $permission_id) {
            $role_has_permissions = new AccessManagementRoleHasPermissions();
            $role_has_permissions->permission_id = $permission_id;
            $role_has_permissions->role_id = $role->id;
            $role_has_permissions->save();
        }
        return response()->json($role, Response::HTTP_OK);
    }

    public function storeUser(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    
        // Create a new UserInformation instance
        $user = new UserInformation();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save();
    
        // Return JSON response for the AJAX request
        return response()->json([
            'title' => 'Success',
            'message' => 'User created successfully!'
        ], Response::HTTP_OK);
    }
    

    public function destroyPermission($id)
    {
        $permission = AccessManagementPermissions::findOrFail($id);
        $permission->delete();
    
        return redirect()->back()->with('success', 'Permission Deleted Successfully');
    }

    public function editPermission(Request $request, $id)
    {
        $permission = AccessManagementPermissions::findOrFail($id);

        $validatedData = $request->validate([
            'editedName' => 'required',
            'description' => 'required'
        ]);
    
        $permission->name = $validatedData['editedName'];
        $permission->description = $validatedData['description'];
        
        $permission->save();
    
        return redirect()->back()->with('success', 'Permission Updated Successfully');
    }
    
    public function destroyRole($id)
    {
        $role = AccessManagementRoles::findOrFail($id);
        $role->delete();

        return redirect()->back()->with('success', 'Role Removed Successfully');
    }

    public function editRole(Request $request, $id)
    {
        $role = AccessManagementRoles::findOrFail($id);

        $validatedData = $request->validate([
            'editedName' => 'required',
        ]);
    
        $role->name = $validatedData['editedName'];
        
        $role->save();
    
        return redirect()->back()->with('success', 'Role Updated Successfully');
    }

    public function destroyUser($id)
    {
        $user = UserInformation::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User Removed Successfully');
    }




}
