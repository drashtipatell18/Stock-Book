<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Book;
use App\Models\Stall;
use Illuminate\Http\Request;
class SalesOrderController extends Controller
{
    public function salesorder()
    {
        // $user = Auth::user();
        // $userRole = strtolower($user->role);
        // if ($userRole == 'admin') {
            $salesorders = SalesOrder::all();
            return view('salesorder.view_salesorder',compact('salesorders'));
        // } 
        // if ($userRole == 'employee') {
        //     return view('employee.404_page');
        // }   
    }
    public function salesorderCreate()
    {
        $stalls    = Stall::pluck('name');
        $books    = Book::pluck('name');
        return view('salesorder.create_salesorder',compact('stalls','books'));
    }
    public function salesorderInsert(Request $request)
    {
        // $request->validate([
        //     'stall_name'   => 'required',
        //     'location'     => 'required',
        //     'book_name'    => 'required',
        //     'sales_price'  => 'required',
        //     'quantity'     => 'required',
        //     'total_price ' => 'required',
        // ]);

        $salesorders = SalesOrder::create([
            // 'book_id'          => $request->input('book_id'),
            'stall_name'       => $request->input('stall_name'),
            'location'         => $request->input('location'),
            'book_name'        => $request->input('book_name'),
            'sales_price'      => $request->input('sales_price'),
            'quantity'         => $request->input('quantity'),
            'total_price'      => $request->input('total_price'),
        ]);

        session()->flash('success', 'SaleOrder added successfully!');
        return redirect()->route('salesorder');

    }
    public function salesorderEdit($id){

        $salesorders = SalesOrder::find($id);
        $stalls    = Stall::pluck('name');
        $books    = Book::pluck('name');
        return view('payment.create_salesorder',compact('stalls','salesorders','books'));
    }

    public function salesorderUpdate(Request $request, $id)
    {
        // $request->validate([
        //     'stall_name'   => 'required',
        //     'location'     => 'required',
        //     'book_name'    => 'required',
        //     'sales_price'  => 'required',
        //     'quantity'     => 'required',
        //     'total_price ' => 'required',
        // ]);

        $salesorders = SalesOrder::find($id);

        $salesorders->update([
            // 'book_id'          => $request->input('book_id'),
            'stall_name'       => $request->input('stall_name'),
            'location'         => $request->input('location'),
            'book_name'        => $request->input('book_name'),
            'sales_price'      => $request->input('sales_price'),
            'quantity'         => $request->input('quantity'),
            'total_price'      => $request->input('total_price'),
        ]);

        session()->flash('success', 'SaleOrder Update successfully!');
        return redirect()->route('salesorder');

    }
    public function salesorderDestroy($id)
    {
        $salesorders = SalesOrder::find($id);
        $salesorders->delete();
        session()->flash('danger', 'SalesOrder Delete successfully!');
        return redirect()->route('salesorder');
    }

}
