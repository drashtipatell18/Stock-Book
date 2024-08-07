<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Book;
use App\Models\Stall;
use App\Models\Stock;
use Illuminate\Http\Request;
class SalesOrderController extends Controller
{
    public function salesorder()
    {
        $salesorders = SalesOrder::with(['stall', 'book'])->get();
        return view('salesorder.view_salesorder', compact('salesorders'));
    }
    public function salesorderCreate()
    {
        $stalls = Stall::pluck('name', 'id')->unique();
        $books = Book::pluck('name', 'id')->unique();
        return view('salesorder.create_salesorder', compact('stalls', 'books'));
    }
    public function salesorderInsert(Request $request)
    {
        $request->validate([
            // 'location'     => 'required',
            'sales_price'  => 'required',
            'quantity'     => 'required',
            // 'total_price ' => 'required',
            'book_id' => 'required',
            'stall_id' => 'required'
        ]);

        $stock = Stock::where('book_id', $request->input('book_id'))->first();
        if(!$stock)
        {
            $customError = "*Stock not available";
            $stalls = Stall::pluck('name', 'id')->unique();
            $books = Book::pluck('name', 'id')->unique();
            return view('salesorder.create_salesorder', compact('customError', 'stalls', 'books'));
        }

        if($stock->quantity < $request->input('quantity'))
        {
            $customError = "*Stock not available";
            $stalls = Stall::pluck('name', 'id')->unique();
            $books = Book::pluck('name', 'id')->unique();
            return view('salesorder.create_salesorder', compact('customError', 'stalls', 'books'));
        }

        $salesorders = SalesOrder::create([
            'stall_id'         => $request->input('stall_id'),
            'location'         => $request->input('location'),
            'book_id'          => $request->input('book_id'),
            'sales_price'      => $request->input('sales_price'),
            'quantity'         => $request->input('quantity'),
            'total_price'      => $request->input('total_price'),
        ]);

        $stock->update([
            'quantity' => $stock->quantity - $request->input('quantity')
        ]);

        session()->flash('success', 'SaleOrder added successfully!');
        return redirect()->route('salesorder');

    }
    public function salesorderEdit($id){

        $salesorders = SalesOrder::find($id);
        $stalls = Stall::pluck('name', 'id')->unique();
        $books = Book::pluck('name', 'id')->unique();
        return view('salesorder.create_salesorder',compact('stalls','salesorders','books'));
    }

    public function salesorderUpdate(Request $request, $id)
    {
        $request->validate([
            // 'location'     => 'required',
            'sales_price'  => 'required',
            'quantity'     => 'required',
            // 'total_price ' => 'required',
            'book_id' => 'required',
            'stall_id' => 'required'
        ]);

        $salesorders = SalesOrder::find($id);

        if($salesorders->quantity == $request->input('quantity'))
        {
            $salesorders->update([
                'book_id'          => $request->input('book_id'),
                'stall_id'         => $request->input('stall_id'),
                'location'         => $request->input('location'),
                'sales_price'      => $request->input('sales_price'),
                'quantity'         => $request->input('quantity'),
                'total_price'      => $request->input('total_price'),
            ]);
        }
        else if($salesorders->quantity > $request->input('quantity'))
        {
            $stock = Stock::where('book_id', $request->input('book_id'))->first();
            $stock->update([
                'quantity' => $stock->quantity + ($salesorders->quantity - $request->input('quantity'))
            ]);
            $salesorders->update([
                'book_id'          => $request->input('book_id'),
                'stall_id'         => $request->input('stall_id'),
                'location'         => $request->input('location'),
                'sales_price'      => $request->input('sales_price'),
                'quantity'         => $request->input('quantity'),
                'total_price'      => $request->input('total_price'),
            ]);
            $stock = Stock::where('book_id', $request->input('book_id'))->first();
        }
        else
        {
            $stock = Stock::where('book_id', $request->input('book_id'))->first();
            if($stock->quantity < ($request->input('quantity') - $salesorders->quantity))
            {
                session()->flash('danger', 'Quantity not available!');
                return back();
            }
            $stock->update([
                'quantity' => $stock->quantity - ($request->input('quantity') - $salesorders->quantity)
            ]);
            $salesorders->update([
                'book_id'          => $request->input('book_id'),
                'stall_id'         => $request->input('stall_id'),
                'location'         => $request->input('location'),
                'sales_price'      => $request->input('sales_price'),
                'quantity'         => $request->input('quantity'),
                'total_price'      => $request->input('total_price'),
            ]);
        }

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
