<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlide;
use Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomeSliderController extends Controller
{
     public function HomeSlider(){

        $homeslide = HomeSlide::find(1);
        return view('admin.home_slide.home_slide_all',compact('homeslide'));

     } // End Method



     public function UpdateSlider(Request $request){



        $slide_id = $request->id;

        if ($request->file('home_slide')) {

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('home_slide')->getClientOriginalExtension();  // 3434343443.jpg
            $img=$manager->read($request->file('home_slide'));

            $img=$img->resize(636,852);

            $img->toJpeg(80)->save(base_path('public/upload/home_slide/'.$name_gen));

            $save_url='upload/home_slide/'.$name_gen;




            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
                'home_slide' => $save_url,

            ]);
            $notification = array(
            'message' => 'Home Slide Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else{

            HomeSlide::findOrFail($slide_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,

            ]);
            $notification = array(
            'message' => 'Home Slide Updated without Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } // end Else

     } // End Method



}
