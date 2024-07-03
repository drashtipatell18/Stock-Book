<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Book;

class CategoryController extends Controller
{
    public function category()
    {
        $categorys = Category::all();
        $books = Book::pluck('name')->unique();
        return view('category.view_category', compact('categorys', 'books'));
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
        return redirect()->route('category')->with('success', 'Category inserted successfully.');
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

        return redirect()->route('category')->with('success', 'Category updated successfully.');
    }

    public function categoryDestroy($id)
    {
        $category = Category::find($id);

        $books = Book::where('category_id', $category->id)->delete();


        if ($books) {
            // return redirect()->route('category')->with('error', 'Category not found.');
            $category->books()->delete();
        }

        // Delete associated books first
        // Book::where('category_id', $id)->delete();

        // Now delete the category
        $category->delete();

        return redirect()->route('category')->with('danger', 'Category and associated books deleted successfully.');
    }



    public function confirmBooksDeletion()
    {
        $categoryId = session()->get('categoryIdToDelete');
        $category = Category::find($categoryId);

        if (!$category) {
            return redirect()->route('category')->with('error', 'Category not found.');
        }

        $books = Book::where('category_id', $categoryId)->get();

        return view('confirm-books-deletion', compact('category', 'books'));
    }


    public function deleteBooks($categoryId)
    {
        Book::where('category_id', $categoryId)->delete();

        return redirect()->route('category')->with('danger', 'Books associated with the category deleted successfully.');
    }
}
