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
        $user = Auth::user();
        $userRole = strtolower($user->role);
        // if ($userRole == 'admin') {
            $scraps = Scrap::all();
            return view('scrap.view_scrap',compact('scraps'));
        // }
        // if ($userRole == 'employee') {
        //     return view('employee.404_page');
        // }
    }
    public function scrapCreate()
    {
        return view('scrap.create_scrap');
    }
    public function scrapInsert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'scrap_weight' => 'required',
            'by_date' => 'required|date',
            'price' => 'required',
        ]);

        $scraps = Scrap::create([
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
        return view('scrap.create_scrap',compact('scraps'));
    }

    public function scrapUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'scrap_weight' => 'required',
            'by_date' => 'required|date',
            'price' => 'required',
        ]);

        $scraps = Scrap::find($id);

        $scraps->update([
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
