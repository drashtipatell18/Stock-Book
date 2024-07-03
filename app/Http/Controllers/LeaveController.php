<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function leave()
    {
        // if (!Auth::check()) {
        //     return redirect()->back()->with('error', 'No user is logged in.');
        // }

        // $user = Auth::user();
        // $userRole = strtolower($user->role);

        // if ($userRole == 'admin' || $userRole == 'supervisor') {

            $employee = Employee::where('email', User::find(Auth()->user()->id)->email)->get()->first();
            $leaves = ((Auth()->user()->role_id != 1)?Leave::with('employee')->where('employee_id', $employee->id)->get():Leave::with('employee')->get());
            return view('admin.view_leave', compact('leaves'));
        // }

        // $userid = Auth::user()->id;

        // if ($userRole == 'employee') {
        //     $leaves = Leave::where('user_id', $userid)->get();
        //     return view('admin.view_leave', compact('leaves'));
        // }
    }

    public function leaveCreate()
    {
        $employee_id = null;
        $user_id = null;


        if (Auth::check()) {
            $user_id = Auth::id();

            $employee = DB::table('employees')
                ->where('user_id', $user_id)
                ->first();

            if ($employee) {
                $employee_id = $employee->id;
                $balanceLeave = $employee->total_leave;
            }
        }

        return view('admin.create_leave', compact('employee_id', 'user_id', 'balanceLeave'));
    }


    public function leaveInsert(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'leave_type' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'totalhours' => 'required|numeric',
            // 'requestto' => 'required',
        ]);

        $balanceLeave = 22; // Initial balance leave, can be retrieved from the database if needed.
        $startDate = Carbon::parse($request->input('startdate'));
        $endDate = Carbon::parse($request->input('enddate'));

        // Calculate the total leave days from start to end date
        $leaveDays = $startDate->diffInDays($endDate) + 1;

        // Calculate total hours
        $totalHours = $request->input('totalhours');

        // Assuming 9 hours is a full workday
        $fullWorkDayHours = 9;

        if ($totalHours < $fullWorkDayHours) {
            $leaveDays = 0.5; // Half-day leave
        }

        // If the calculated leave days exceed the balance leave, return an error
        if ($leaveDays > $balanceLeave) {
            return back()->withErrors(['leave' => 'Insufficient balance leave'])->withInput($request->all());
        }

        if(!$request->has('status'))
        {
            $request->input('status', 'pending');
        }

        // Add leave record
        $leave = Leave::create([
            'user_id' => $request->input('user_id'),
            'employee_id' => $request->input('employee_id'),
            'reason' => $request->input('reason'),
            'startdate' => $request->input('startdate'),
            'enddate' => $request->input('enddate'),
            'leave_type' => $request->input('leave_type'),
            'time_from' => $request->input('time_from'),
            'time_to' => $request->input('time_to'),
            'totalhours' => $request->input('totalhours'),
            'status' => 'pending',
            // 'requestto' => $request->input('requestto'),
        ]);

        // $employee = Employee::find($request->input('employee_id'));
        // $newBalance = $employee->total_leave - $leaveDays; // Subtract half-day
        // dd($newBalance);

        if ($request->input('status') == 'approved' && $request->input('employee_id')) {
            $employee = Employee::find($request->input('employee_id'));
            if ($employee) {
                // Adjust balance leave based on total hours
                if ($totalHours < $fullWorkDayHours) { // Less than a full workday
                    $newBalance = $employee->total_leave - $leaveDays; // Subtract half-day
                } else {
                    $newBalance = $employee->total_leave - $leaveDays; // Subtract full days
                }
                $employee->update(['total_leave' => $newBalance]);
            }
        }

        session()->flash('success', 'Leave added successfully!');
        return redirect()->route('leave');
    }



    public function leaveEdit($id)
    {
        $employee_id = null;
        $user_id = null;
        $balanceLeave = null;

        if (Auth::check()) {
            $user_id = Auth::id();

            $employee = DB::table('employees')
                ->where('user_id', $user_id)
                ->first();

            if ($employee) {
                $employee_id = $employee->id;
                $balanceLeave = $employee->total_leave;
            }
        }

        $leaves = Leave::with('employee')->find($id);

        return view('admin.create_leave', compact('leaves', 'employee_id', 'user_id', 'balanceLeave'));
    }

    public function changeStatus(Request $request,$id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = $request->input('status');
        $leave->save();

        // You can return a response if needed
        return response()->json(['message' => 'Leave status updated successfully']);
    }

    public function leaveUpdate(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'reason' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'leave_type' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'totalhours' => 'required',
            // 'requestto' => 'required',
        ]);
        $balanceLeave = 22;

        $startDate = Carbon::parse($request->input('startdate'));
        $endDate = Carbon::parse($request->input('enddate'));

        $leaveDays = $startDate->diffInDays($endDate) + 1;

        if ($leaveDays > $balanceLeave) {
            return back()->withErrors(['leave' => 'Insufficient balance leave'])->withInput($request->all());
        }

        $leaves = Leave::find($id);

        // Update the balance leave for the employee
        if ($request->input('status') == 'approved' && $leaves->status != 'approved') {
            $employee = Employee::find($leaves->employee_id);
            if ($employee) {
                if($request->totalhours <= 2)
                {
                    $newBalance = $employee->total_leave - 0;
                }
                else if($request->totalhours <= 4)
                {
                    $newBalance = $employee->total_leave - 0.5;
                }
                else
                {
                    $newBalance = $employee->total_leave - $leaveDays;
                }
                $employee->update(['total_leave' => $newBalance]);
            }
        }

        $leaves->update([
            'user_id'    => $request->input('user_id'),
            'employee_id'=> $request->input('employee_id'),
            'reason'     => $request->input('reason'),
            'startdate'  => $request->input('startdate'),
            'enddate'    => $request->input('enddate'),
            'leave_type' => $request->input('leave_type'),
            'time_from'  => $request->input('time_from'),
            'time_to'    => $request->input('time_to'),
            'totalhours' => $request->input('totalhours'),
            'status'     => 'pending'
            // 'requestto'  => $request->input('requestto'),
        ]);

        session()->flash('success', 'Leave Update successfully!');
        return redirect()->route('leave');
    }

    public function leaveDestroy($id)
    {
        $leaves = Leave::find($id);
        $leaves->delete();
        return redirect()->back();
        session()->flash('danger', 'Leave Delete successfully!');
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $leave = Leave::find($id);
        if ($leave) {
            $leave->status = 1;
            $leave->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Entity not found.']);
    }


}
