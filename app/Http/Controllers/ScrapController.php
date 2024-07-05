<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Scrap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScrapController extends Controller
{
    public function scrap()
    {
        $scraps = Scrap::all();
        return view('scrap.view_scrap',compact('scraps'));
    }
    public function scrapCreate()
    {
        $customerNames = Scrap::pluck('customer_name')->unique()->toArray();
        return view('scrap.create_scrap', compact('customerNames'));
    }
    public function scrapInsert(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'name' => 'required',
            'scrap_weight' => 'required',
            'by_date' => 'required|date',
            'price' => 'required',
            'to_date' => 'required|date',
        ]);
        $name = $request->input('customer_name');
        if(!empty($request->input('customer_name_text')))
        {
            $name = $request->input('customer_name_text');
        }
        else if(!empty($request->input('customer_name_select')))
        {
            $name = $request->input('customer_name_select');
        }

        $scraps = Scrap::create([
            'customer_name'    => $name,
            'name'             => $request->input('name'),
            'scrap_weight'     => $request->input('scrap_weight'),
            'by_date'          => $request->input('by_date'),
            'price'            => $request->input('price'),
            'to_date'          => $request->input('to_date'),
        ]);

        session()->flash('success', 'Scrap added successfully!');
        return redirect()->route('scrap');

    }
    public function scrapEdit($id){

        $scraps = Scrap::find($id);
        $customerNames = Scrap::pluck('customer_name')->unique()->toArray();
        return view('scrap.create_scrap',compact('scraps','customerNames'));
    }

    public function scrapUpdate(Request $request, $id)
    {
        $request->validate([
            // 'customer_name' => 'required',
            'name' => 'required',
            'scrap_weight' => 'required',
            'by_date' => 'required|date',
            'price' => 'required',
            'to_date' => 'required|date',
        ]);

        $name = $request->input('customer_name');
        if(!empty($request->input('customer_name_text')))
        {
            $name = $request->input('customer_name_text');
        }
        else if(!empty($request->input('customer_name_select')))
        {
            $name = $request->input('customer_name_select');
        }

        $scraps = Scrap::find($id);
        $scraps->update([
            // 'customer_name'    => $name,
            'name'             => $request->input('name'),
            'scrap_weight'     => $request->input('scrap_weight'),
            'by_date'          => $request->input('by_date'),
            'price'            => $request->input('price'),
            'to_date'          => $request->input('to_date'),
        ]);

        session()->flash('success', 'Scrap Update successfully!');
        return redirect()->route('scrap');

    }
    public function scrapDestroy($id)
    {
        $scraps = Scrap::find($id);
        $scraps->delete();
        session()->flash('danger', 'Scrap Delete successfully!');
        return redirect()->route('scrap');
    }

}
