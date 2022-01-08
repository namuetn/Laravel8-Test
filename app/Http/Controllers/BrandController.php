<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(5); 

        return view('admin.brand.index', compact('brands'));
    }

    public function Storebrand(Request $request)
    {
        $validateData = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:png,jpg,jpeg',
        ]);

        $brandImage = $request->file('brand_image');
        // $nameGenarate = hexdec(uniqid());
        // $imgExtention = strtolower($brandImage->getClientOriginalExtension());
        // $imageName = $nameGenarate . '.' . $imgExtention;
        // $uploadLocation = 'image/brand/';
        // $lastImage = $uploadLocation . $imageName;
        // $brandImage->move($uploadLocation, $imageName);

        $nameGenarate = hexdec(uniqid()) . '.' . $brandImage->getClientOriginalExtension();
        $lastImage = 'image/brand/' . $nameGenarate;
        Image::make($brandImage)->resize(300, 200)->save($lastImage);

        Brand::insert([
            'title' => $request->brand_name,
            'brand_image' => $lastImage,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Brand Inserted Succesfully');
    }

    public function Edit($id)
    {
        $brand = Brand::find($id);

        return view('admin.brand.edit', compact('brand'));
    }

    public function Update(Request $request, $id)
    {
        $validateData = $request->validate([
            'brand_name' => 'required|min:4',
        ]);

        $oldImage = $request->old_image;
        $brandImage = $request->file('brand_image');

        if ($brandImage) {
            $nameGenarate = hexdec(uniqid());
            $imgExtention = strtolower($brandImage->getClientOriginalExtension());
            $imageName = $nameGenarate . '.' . $imgExtention;
            $uploadLocation = 'image/brand/';
            $lastImage = $uploadLocation . $imageName;
            $brandImage->move($uploadLocation, $imageName);

            unlink($oldImage);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $lastImage,
                'created_at' => Carbon::now(),
            ]);
        } else {
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('all.brand')->with('success', 'Brand Updated Succesfully');
    }

    public function Delete($id)
    {
        $image = Brand::find($id)->brand_image;

        unlink($image);
        Brand::find($id)->delete();

        return redirect()->route('all.brand')->with('success', 'Brand Deleted Succesfully');
    }

    public function Multipic()
    {
        $images = Multipic::all();

        return view('admin.multipic.index', compact('images'));
    }

    public function StoreImg(Request $request)
    {
        $image = $request->file('image');

        foreach($image as $multiImg) {
            $nameGenarate = hexdec(uniqid()) . '.' . $multiImg->getClientOriginalExtension();
            $lastImage = 'image/multi/' . $nameGenarate;
            Image::make($multiImg)->resize(300, 200)->save($lastImage);

            Multipic::insert([
                'image' => $lastImage,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Brand Inserted Succesfully');
    }

    public function Logout()
    {
        auth()->logout();

        return redirect()->route('login')->with('success', 'User Logout');
    }
}
