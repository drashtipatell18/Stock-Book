<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Stall;
use App\Models\Stock;
use App\Models\Book;
use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\SalesOrder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function calendar(){
        $user = Auth::user();
        $userid = Auth::user()->id;
        $currentYear = Carbon::now()->year;
    
        // Determine the query based on user role
        if ($user->role == 'admin') {
            // Admin can see all approved leaves
            $leavesQuery = Leave::where('status', 'approved');
        } else {
            $leavesQuery = Leave::where('status', 'approved')
                                ->where('user_id', $userid);
        }
    
        // Fetch and map leave events
        $leaveEvents = $leavesQuery->get(['startdate', 'enddate', 'employee_id', 'totalhours', 'status'])
            ->flatMap(function ($leave) {
                $events = [];
                if ($leave->employee) {
                    // Iterate over each leave
                    $leaveStartDate = date('Y-m-d', strtotime($leave->startdate));
                    $leaveEndDate = date('Y-m-d', strtotime($leave->enddate));
    
                    // Calculate the number of days the leave spans
                    $startDate = new \DateTime($leaveStartDate);
                    $endDate = new \DateTime($leaveEndDate);
                    $interval = $startDate->diff($endDate);
                    $leaveDays = $interval->days + 1; // Add 1 to include both start and end dates
                    // Add each day of the leave as a separate event
                    for ($i = 0; $i < $leaveDays; $i++) {
                        $events[] = [
                            'title' => $leave->employee->firstname . "'s Leave",
                            'start' => $startDate->format('Y-m-d'), // Use ISO 8601 date format
                            'allDay' => true, // Consider it as an all-day event
                            'color' => in_array($leave->totalhours, ['3', '4']) ? 'grey' : 'green', // Updated condition
                            'textColor' => 'white',
                        ];
                        // Move to the next day
                        $startDate->modify('+1 day');
                    }
                }
                return $events;
            })
            ->all();

        // Fetch all employee birthdays for the current year
        $birthdayEvents = Employee::all(['id', 'firstname', 'dob'])
            ->map(function ($employee) use ($currentYear) {
                if (isset($employee->dob)) {
                    $dob = Carbon::parse($employee->dob);
                    $birthdayDate = Carbon::createFromDate($currentYear, $dob->month, $dob->day);
                    return [
                        'title' => $employee->firstname . "'s Birthday",
                        'start' => $birthdayDate->toDateString(),
                        'allDay' => true,
                        'color' => '#FFD700',
                        'textColor' => 'black',
                    ];
                }
            })
            ->filter()
            ->all();

            // Fetch holidays
            $holidayEvents = Holiday::all(['name', 'date'])
            ->map(function ($holiday) {
                return [
                    'title' => $holiday->name,
                    'start' => $holiday->date,
                    'allDay' => true,
                    'color' => '#FF4500',
                    'textColor' => 'white',
                ];
            })
            ->all();
        // Merge and return all events
        $leaves = array_merge($leaveEvents, $birthdayEvents,$holidayEvents);
        return view('calendar.view_calendar', compact('leaves'));
    }
    public function dashboard()
    {
        $category = Category::count();
        $stall = Stall::count();
        $stock = Stock::count();
        $book = Book::count();
        return view('dashboard',compact('category','stall','stock','book'));
    }
    public function showForgetPasswordForm()
    {
        return view('auth.forgetpass');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        // Find the user by the provided email
        $user = User::where('email', $email)->first();

        // Check if the user exists
        if ($user) {
            // Generate a new remember token for the user
            $user->remember_token = Str::random(40);
            $user->save();

            // Send the password reset email to the user
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            // Redirect back with a success message
            return back()->with('success', 'Password reset link sent successfully.');
        } else {
            // Redirect back with an error message if the user was not found
            return back()->with('danger', 'User not found.');
        }
    }

    public function reset($token)
    {
        $user = User::where('remember_token','=',$token)->first();
        if(!empty($user)){
            $data['user'] = $user;
            $data['token'] = $user->remember_token;
            return view('auth.reset', $data);
        }
    }

    public function postReset($token, Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8',
            ]);

        if ($request->newpassword !== $request->confirmpassword) {
            return redirect()->back()->with('error', 'The new password confirmation does not match.');
        }

        $user = User::where('remember_token','=',$token)->first();
        if(!empty($user)){
            if(empty($user->email_verified_at)){
                $user->email_verified_at = now();
            }
            $user->remember_token =  Str::random(40);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect('login')->with('success', 'Password successfully reset.');
        }
    }

    public function getDashboardChart()
    {
        $monthlySales = SalesOrder::monthlySales()->get();
        $salesData = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthSales = $monthlySales->firstWhere('month', $i);
            $salesData[] = $monthSales ? $monthSales->total_sales : 0;
        }
        return response()->json($salesData);
    }
}
