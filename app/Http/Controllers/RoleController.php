<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
    public function role()
    {
        $roles = Role::all();
        $user = auth()->user();
        return view('view_role', compact('roles','user'));
    }

    public function roleCreate()
    {
        return view('create_role');
    }

    public function roleStore(Request $request)
    {
        $request->validate([
            'role_name' => 'required',
        ]);
        Role::create([
            'role_name' => $request->input('role_name'),
        ]);

        return redirect()->route('role')->with('success', 'Role created successfully.');
    }

    public function roleEdit($id)
    {
        $role = Role::find($id);
        return view('create_role', compact('role'));
    }

    public function roleUpdate(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required',
        ]);

        $role = Role::find($id);
        $role->update([
            'role_name' => $request->input('role_name')
        ]);
        return redirect()->route('role')->with('success', 'Role updated successfully.');
    }

    public function roleDestroy($id)
    {
        $role = Role::find($id);
        $users = User::where('role_id', $role->id)->delete();
        if ($users) {
            $role->users()->delete();
        }
        $role->delete();

        return redirect()->route('role')->with('success', 'Role deleted successfully.');
    }
}
