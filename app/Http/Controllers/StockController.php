<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function stock()
    {
        $stocks = Stock::all();
        return view('stock.view_stock',compact('stocks'));
    }

    public function stockCreate()
    {
        $books = Book::all();
        return view('stock.create_stock', compact('books'));
    }

    public function stockStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'book_name' => 'required'
        ]);

        $check = Stock::where('book_id', $request->input('name'))->first();
        if($check)
        {
            $check->quantity = $request->input('quantity');
            $check->price = $request->input('price');

            $check->update([
                'quantity' => $request->input('quantity') + $check->quantity,
                'price' => $request->input('price')
            ]);
        }
        else
        {
            $stocks = Stock::create([
                'name'      => $request->input('book_name'),
                'quantity'     => $request->input('quantity'),
                'price'     => $request->input('price'),
                'book_id'   => $request->input('name')
            ]);
        }


        session()->flash('success', 'Stock added successfully!');
        return redirect()->route('stock');

    }
    public function stockEdit($id)
    {
        $stocks = Stock::find($id);
        return view('stock.create_stock', compact('stocks'));
    }

    public function stockUpdate(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $stocks = Stock::find($id);


        $stocks->update([
            'name'      => $request->input('name'),
            'quantity'     => $request->input('quantity'),
            'price'     => $request->input('price'),
        ]);

        session()->flash('success', 'Stock added successfully!');
        return redirect()->route('stock');
    }

    public function stockDestroy($id)
    {
        $stocks = Stock::find($id);
        $stocks->delete();
        session()->flash('danger', 'Stock Delete successfully!');
        return redirect()->route('stock');
    }
}
