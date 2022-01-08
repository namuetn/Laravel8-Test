<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Image;

class HomeController extends Controller
{
    public function HomeSlider()
    {
        $sliders = Slider::latest()->get();

        return view('admin.slider.index', compact('sliders'));
    }

    public function AddSlider()
    {
        return view('admin.slider.create');
    }

    public function StoreSlider(Request $request)
    {
        $sliderImage = $request->file('image');
        $nameGenarate = hexdec(uniqid()) . '.' . $sliderImage->getClientOriginalExtension();
        $lastImage = 'image/slider/' . $nameGenarate;
        Image::make($sliderImage)->resize(1920, 1088)->save($lastImage);

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $lastImage,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('home.slider')->with('success', 'Slider Inserted Succesfully');
    }

    public function EditSlider($id)
    {
        $slider = Slider::find($id);

        return view('admin.slider.edit', compact('slider'));
    }

    public function UpdateSlider(Request $request, $id)
    {
        $oldImage = $request->old_image;
        $sliderImage = $request->file('image');

        if ($sliderImage) {
            $nameGenarate = hexdec(uniqid()) . '.' . $sliderImage->getClientOriginalExtension();
            $lastImage = 'image/slider/' . $nameGenarate;
            Image::make($sliderImage)->resize(1920, 1088)->save($lastImage);
            unlink($oldImage);
    
            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $lastImage,
                'created_at' => Carbon::now(),
            ]);    
        } else {
            Slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'created_at' => Carbon::now(),
            ]);    
        }

        return redirect()->route('home.slider')->with('success', 'Slider Inserted Succesfully');
    }

    public function DeleteSlider($id)
    {
        $image = Slider::find($id)->image;

        unlink($image);
        Slider::find($id)->delete();

        return redirect()->route('home.slider')->with('success', 'Slider Deleted Succesfully');
    }
}
