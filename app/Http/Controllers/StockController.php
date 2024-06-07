<?php

namespace App\Http\Controllers;

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
        return view('stock.create_stock');
    }
}
