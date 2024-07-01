<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function book()
    {
        $books = Book::with('category')->get();
        return view('book.view_book', compact('books'));
    }
    public function bookCreate()
    {
        $categorys = Category::pluck('category_name');
        return view('book.create_book', compact('categorys'));
    }

    public function bookInsert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $filename = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
        }

        $book = Book::create([
            'name'           => $request->input('name'),
            'category_id'  => $request->input('category_id'),
            'price'          => $request->input('price'),
            'image'          => $filename,
        ]);

        session()->flash('success', 'Book added successfully!');
        return redirect()->route('book');
    }

    public function bookEdit($id)
    {
        $books = Book::find($id);
        $categorys = Category::pluck('category_name');
        return view('book.create_book', compact('books', 'categorys'));
    }

    public function bookUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $books = Book::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $filename);
            $books->image = isset($filename) ? $filename : null;
        }

        $books->update([
            'name'           => $request->input('name'),
            'category_id'  => $request->input('category_id'),
            'price'          => $request->input('price'),
        ]);

        session()->flash('success', 'Books Update successfully!');
        return redirect()->route('book');
    }

    public function bookDestroy($id)
    {
        $books = Book::find($id);
        $books->delete();
        session()->flash('danger', 'Book Delete successfully!');
        return redirect()->route('book');
    }
}
