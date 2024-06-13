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
        return view('permission.view_permission',compact('permissions','roles'));
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
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|integer',
            'name' => 'required',
            'slug' => 'required',
        ]);

        // Create a new permission record
        Access_Permission::create([
            'role_id' => $request->input('role_id'),
            'status' => $request->input('status'),
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Permission Updated successfully.');
    }
    
}
