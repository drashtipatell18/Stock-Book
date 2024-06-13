<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Access_Permission;
use App\Models\Role;

class PermissionController extends Controller
{
    public function permission(Request $request){

        $roles = Role::pluck('role_name', 'id')->toArray();
        $permissions = Permission::all();
        $currentPermissions = [];
    
        // Check if a role is selected
        $selectedRoleId = $request->input('role_id');
        if ($selectedRoleId) {
            // Fetch the role and its permissions
            $role = Role::with('permissions')->find($selectedRoleId);
            if ($role) {
                $currentPermissions = $role->permissions->pluck('id')->toArray();
            }
        }
        return view('permission.view_permission',compact('permissions','roles','currentPermissions'));
    }

    public function permissionCreate(){
        return view('permission.create_permission');
    }

    public function permissionInsert(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $permission = Permission::create([
            'role_id'       => $request->input('role_id'),
            'name'       => $request->input('name'),
            'slug'       => $request->input('slug'),
        ]);

        session()->flash('success', 'Permission added successfully!');
        return redirect()->route('permission');
    }

    public function permissionEdit($id){
        $permissions = Permission::find($id);
        return view('permission.create_permission', compact('permissions'));
    }

    public function permissionUpdate(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $permissions = Permission::find($id);

        $permissions->update([
            'role_id'    => $request->input('role_id'),
            'name'       => $request->input('name'),
            'slug'       => $request->input('slug'),
        ]);

        session()->flash('success', 'Permission Updated successfully!');
        return redirect()->route('permission');
    }

    public function updatePermissions(Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|integer',
        ]);

        // Create a new permission record
        Access_Permission::create([
            'role_id' => $validatedData['role_id'],
            'status' => $validatedData['status'],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Permission Updated successfully.');
    }
}
