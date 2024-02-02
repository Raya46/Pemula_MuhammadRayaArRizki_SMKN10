<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();

        return view('admin.category', compact('categories'));
    }

    public function store(Request $request){
        Category::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function putCategory(Request $request, $id){
        $category = Category::find($id);

        $category->update([
            'name' => $request->name 
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function destroy($id){
        $category = Category::find($id);

        $category->delete();

        return redirect()->back()->with('status', 'success');
    }

}
