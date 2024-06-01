<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        $categorys = Category::all();
        return view('category.view_category',compact('categorys'));
    }
    public function createCategory()
    {
        return view('category.create_category');
    }
      
    public function storeCategory(Request $request)
    {

        $request->validate([
            'category_name' => 'required',
        ]);
        
        Category::create([
            'category_name' => $request->input('category_name'),
        ]);
        
        return redirect()->route('category');
    }
    
    
    public function categoryEdit($id)
    {
        $category = Category::find($id);
        return view('category.create_category', compact('category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
    
        $category = Category::find($id);
    
       
        // Update category name
        $category->update([
            'category_name' => $request->input('category_name')
        ]);
    
        return redirect()->route('category');
    }
    
    public function categoryDestroy($id)
    {
            $category = Category::find($id);
            $category->delete();
            return redirect()->back();
    }
    
}
