<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
// use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function users(){
        // $user = Auth::user();
        // $userRole = strtolower($user->role);
        // if ($userRole == 'admin') {
            $users = User::all();
            return view('admin.view_user',compact('users'));
        // }
        // if ($userRole == 'employee') {
        //     return view('employee.404_page');
        // }
    }

    public function userCreate(){
        $roles = Role::pluck('role_name');
        return view('admin.create_user',compact('roles'));
    }

    public function userInsert(Request $request ){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $filename = '';
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
        }

        $user = User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
            'role'     => $request->input('role'),
            'image'     => $filename,
        ]);

        session()->flash('success', 'User added successfully!');
        return redirect()->route('user');
    }

    public function userEdit($id){
        $users = User::find($id);
        $roles = Role::pluck('role_name');
        return view('admin.create_user', compact('users','roles'));
    }

    public function userUpdate(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $users = User::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
            $users->image = isset($filename) ? $filename : null;
        }

        $users->update([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'role'     => $request->input('role'),
         ]);

        session()->flash('success', 'User Update successfully!');
        return redirect()->route('user');
    }

    public function userDestroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back();
        session()->flash('danger', 'User Delete successfully!');
        return redirect()->back();
    }
}
