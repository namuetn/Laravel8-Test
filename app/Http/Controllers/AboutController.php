<?php

namespace App\Http\Controllers;

use App\Models\HomeAbout;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function HomeAbout()
    {
        $homeAbout = HomeAbout::latest()->get();

        return view('admin.home.index', compact('homeAbout'));
    }

    public function AddAbout()
    {
        return view('admin.home.create');
    }

    public function StoreAbout(Request $request)
    {
       HomeAbout::create($request->only([
           'title',
           'short_dis',
           'long_dis',
       ]));

       return redirect()->route('home.about')->with('success', 'Home About Inserted Succesfully');
    }

    public function EditAbout($id)
    {
        $homeAbout = HomeAbout::findOrFail($id);

        return view('admin.home.edit', compact('homeAbout'));
    }

    public function UpdateAbout(Request $request, $id)
    {
        HomeAbout::find($id)->update($request->only([
            'title',
            'short_dis',
            'long_dis',
        ]));

        return redirect()->route('home.about')->with('success', 'Home About Updated Succesfully');
    }

    public function DeleteAbout($id)
    {
        HomeAbout::find($id)->delete();

        return redirect()->back()->with('success', 'Home About Deleted Succesfully');
    }
}
