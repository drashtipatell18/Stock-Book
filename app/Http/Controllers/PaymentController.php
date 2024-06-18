<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment()
    {
        $payments = Payment::all();
        return view('payment.view_payment',compact('payments'));
    }
    public function paymentCreate()
    {
        $employees = Employee::pluck('firstname','id');
        return view('payment.create_payment',compact('employees'));
    }
    public function paymentInsert(Request $request)
    {
        $request->validate([
            'total_price' => 'required',
            'status' => 'required',
            // 'accountno' => 'required|numeric',
            // 'bankname' => 'required',
            // 'ifsccode' => 'required',
            'payment_date' => 'required',
            'salary_type' => 'required',
        ]);

        $payment = Payment::create([
            'employee_id'      => $request->input('employee_id'),
            'accountno'        => $request->input('accountno'),
            'bankname'         => $request->input('bankname'),
            'ifsccode'         => $request->input('ifsccode'),
            'payment_date'     => $request->input('payment_date'),
            'total_price'      => $request->input('total_price'),
            'salary_type'      => $request->input('salary_type'),
            'status'           => $request->input('status'),

        ]);

        session()->flash('success', 'Payment added successfully!');
        return redirect()->route('payment');

    }
    public function paymentEdit($id){

        $payments = Payment::find($id);
        $employees = Employee::pluck('firstname','id');
        return view('payment.create_payment',compact('employees','payments'));
    }

    public function paymentUpdate(Request $request, $id)
    {
        $payments = Payment::find($id);

        $payments->update([
            'employee_id'      => $request->input('employee_id'),
            'accountno'        => $request->input('accountno'),
            'bankname'         => $request->input('bankname'),
            'ifsccode'         => $request->input('ifsccode'),
            'payment_date'     => $request->input('payment_date'),
            'total_price'      => $request->input('total_price'),
            'salary_type'      => $request->input('salary_type'),
            'status'           => $request->input('status'),
        ]);

        session()->flash('success', 'Payment Update successfully!');
        return redirect()->route('payment');

    }
    public function paymentDestroy($id)
    {
        $payments = Payment::find($id);
        $payments->delete();
        session()->flash('danger', 'Payment Delete successfully!');
        return redirect()->route('payment');
    }

}
