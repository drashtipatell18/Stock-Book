<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stall;
// use Illuminate\Support\Facades\Auth;

class StallController extends Controller
{
    public function stall(){
            $stalls = stall::all();
            return view('admin.view_stall',compact('stalls'));
    }

    public function createStall(){
        return view('admin.create_stall');
    }

    public function storeStall(Request $request ){
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'owner_name' => 'required',
        ]);

        $stall = stall::create([
            'name'      => $request->input('name'),
            'location'     => $request->input('location'),
            'owner_name'     => $request->input('owner_name'),
        ]);

        session()->flash('success', 'Stall added successfully!');
        return redirect()->route('stall');
    }

    public function StallEdit($id){
        $stalls = stall::find($id);
        return view('admin.create_stall', compact('stalls'));
    }

    public function StallUpdate(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'owner_name' => 'required',
        ]);

        $stalls = stall::find($id);

        $stalls->update([
            'name'      => $request->input('name'),
            'location'     => $request->input('location'),
            'owner_name'     => $request->input('owner_name'),
         ]);

        session()->flash('success', 'Stall Update successfully!');
        return redirect()->route('stall');
    }

    public function userDestroy($id)
    {
        $stalls = stall::find($id);
        $stalls->delete();
        session()->flash('danger', 'Stall Delete successfully!');
        return redirect()->route('stall');
    }
}
