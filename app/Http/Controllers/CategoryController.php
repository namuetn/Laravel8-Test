<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllCat()
    {
        $categories = Category::latest()->paginate(2);
        // $categories = DB::table('categories')
        //     ->join('users', 'categories.user_id', 'users.id')
        //     ->select('categories.*', 'users.name')
        //     ->latest()
        //     ->paginate(2);

        return view('admin.category.index', compact('categories'));
    }

    public function AddCat(Request $request)
    {
        $validateData = $request->validate([
            'category_name' => 'required|unique:categories|max:10'
        ],
        [
            'category_name.required' => 'Hãy nhập tên danh mục',
            'category_name.max' => 'Danh mục tối thiểu 10 ký tự',
        ]);

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Category Inserted Succesfully');
    }

    public function Edit($id)
    {
        $category = Category::find($id);

        return view('admin.category.edit', compact('category'));
    }

    public function Update(Request $request, $id)
    {
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('all.category')->with('success', 'Category Updated Succesfully');
    }
}
