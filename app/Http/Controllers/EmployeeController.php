<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function employees(){
        $user = Auth::user();
        $userRole = strtolower($user->role);

        // if ($userRole == 'admin') {
            $employees = Employee::all();
            return view('employee.view_employee',compact('employees'));
        // } 
        // if ($userRole == 'employee') {
        //     return view('employee.404_page');
        // }
    }

    public function employeeCreate(){
        $users = User::pluck('name', 'id');
        return view('employee.create_employee',compact('users'));
    }

    public function getEmail($id)
    {
        return response()->json(["email" => User::find($id)->email]);
    }
    public function employeeInsert(Request $request ){
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'user_id' => 'required',
            'dob' => 'required|date',
            'gender' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phoneno' => 'required|numeric',
            'salary' => 'required|numeric',
            'joiningdate' => 'required|date',
        ]);

    
        if ($request->hasFile('profilepic')) {
            $subimages = [];

            foreach ($request->file('profilepic') as $file) {
                $subImageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move('images', $subImageName);

                // Add the filename to the array
                $subimages[] = $subImageName;
            }
            $employeeimg = json_encode($subimages);
        }

        $employee = Employee::create([
            'user_id'       => $request->input('user_id'),
            'firstname'      => $request->input('firstname'),
            'lastname'       => $request->input('lastname'),
            'dob'            => $request->input('dob'),
            'email'          => $request->input('email'),
            'address'        => $request->input('address'),
            'phoneno'        => $request->input('phoneno'),
            'gender'         => $request->input('gender'),
            'salary'         => $request->input('salary'),
            'joiningdate'    => $request->input('joiningdate'),
            'profilepic'     => $employeeimg,
        ]);

        session()->flash('success', 'Employee added successfully!');
        return redirect()->route('employee');
    }

    public function employeeEdit($id){
        $employees = Employee::find($id);
        $users = User::pluck('name', 'id');
        return view('employee.create_employee', compact('employees','users'));
    }

    public function employeeUpdate(Request $request,$id){
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'user_id' => 'required',
            'dob' => 'required|date',
            'email' => 'required|email',
            'address' => 'required',
            'phoneno' => 'required|numeric',
            'gender' => 'required',
            'salary' => 'required|numeric',
            'joiningdate' => 'required|date',
        ]);

        $employees = Employee::find($id);

        // if ($request->hasFile('profilepic')) {
        //     $image = $request->file('profilepic');
        //     $employeeimg = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $employeeimg);
            
        //     // Optionally delete the old image
        //     if ($employees->profilepic) {
        //         $oldImagePath = public_path('images') . '/' . $employees->profilepic;
        //         if (file_exists($oldImagePath)) {
        //             @unlink($oldImagePath);
        //         }
        //     }
        //     $employees->profilepic = $employeeimg;
        // }

        if ($request->hasFile('profilepic')) {
            $subimages = [];
            foreach ($request->file('profilepic') as $file) {
                $subImageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move('images', $subImageName);
                $subimages[] = $subImageName;
            }
            $employees->profilepic = json_encode($subimages);
        }

        $employees->update([
            'user_id'       => $request->input('user_id'),
            'firstname'      => $request->input('firstname'),
            'lastname'       => $request->input('lastname'),
            'dob'            => $request->input('dob'),
            'email'          => $request->input('email'),
            'address'        => $request->input('address'),
            'phoneno'        => $request->input('phoneno'),
            'gender'         => $request->input('gender'),
            'salary'         => $request->input('salary'),
            'joiningdate'    => $request->input('joiningdate'),
         ]);

        session()->flash('success', 'Employee Update successfully!');
        return redirect()->route('employee');
    }

    public function employeeDestroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        session()->flash('danger', 'Employee Delete successfully!');
        return redirect()->back();
    }
    public function myProfile()
    {
        $employee = null; // Initialize the variable
        $id = null; // Initialize the variable

        if (Auth::check()) {
            $userid = Auth::user()->id;
            $employe = Auth::user()->employee;
            if ($employe) {
                $id = $employe->id;
            }
            $employee = Employee::find($id);
        }

        return view('employee.view_my_profile', compact('id', 'employee'));
    }


    public function editProfile($id) {
        $id = null;
        if (Auth::check()) {
            $id = Auth::user()->id;
            $employe = Auth::user()->employee;
            if ($employe) {
                $id = $employe->id;
            }
            $employee = Employee::find($id);

        }
        $employee = Employee::findOrFail($id); // Assuming you have an Employee model
        return view('employee.view_my_profile', compact('employee','id'));
    }

    public function Profileupdate(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email',
            'phoneno'   => 'required',
            'position'  => 'required'
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('my.profile')->with('success', 'Profile updated successfully');
    }

}
