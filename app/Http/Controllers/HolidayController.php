<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function Holiday(){
        $holidays = Holiday::all();
        return view('admin.view_holiday',compact('holidays'));
    }

    public function holidayCreate(){
        return view('admin.create_holiday');
    }

    public function holidayInsert(Request $request ){
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'day' => 'required',
        ]);

        $holiday = Holiday::create([
            'name' => $request->input('name'),
            'date'     => $request->input('date'),
            'day'       => $request->input('day'),
        ]);

        session()->flash('success', 'Holiday added successfully!');
        return redirect()->route('holiday');
    }

    public function holidayEdit($id){
        $holidays = Holiday::find($id);
        return view('admin.create_holiday', compact('holidays'));
    }

    public function holidayUpdate(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'day' => 'required',
        ]);

        $holidays = Holiday::find($id);
        $holidays->update([
            'name' => $request->input('name'),
            'date'     => $request->input('date'),
            'day'       => $request->input('day'),
         ]);

        session()->flash('success', 'Holiday Update successfully!');
        return redirect()->route('holiday');
    }

    public function holidayDestroy($id)
    {
        $holidays = Holiday::find($id);
        $holidays->delete();
        return redirect()->back();
        session()->flash('danger', 'Holiday Delete successfully!');
        return redirect()->back();
    }

}
