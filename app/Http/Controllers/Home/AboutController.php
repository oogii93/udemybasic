<?php

namespace App\Http\Controllers\Home;

use Image;
use App\Models\About;

use App\Models\MultiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class AboutController extends Controller
{
    public function AboutPage(){

        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));

     }

     public function UpdateAbout(Request $request){



        $about_id = $request->id;

        if ($request->file('about_image')) {

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('about_image')->getClientOriginalExtension();  // 3434343443.jpg
            $img=$manager->read($request->file('about_image'));

            $img=$img->resize(523,605);

            $img->toJpeg(80)->save(base_path('public/upload/home_about/'.$name_gen));

            $save_url='upload/home_about/'.$name_gen;


            // $image = $request->file('home_slide');

            // Image::make($image)->resize(636,852)->save('upload/home_slide/'.$name_gen);
            // $save_url = 'upload/home_slide/'.$name_gen;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,

                'about_image' => $save_url,

            ]);
            $notification = array(
            'message' => 'About Slide Updated with Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } else{

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,


            ]);
            $notification = array(
            'message' => 'About Slide Updated without Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

        } // end Else

     } // End Method

     public function HomeAbout()
     {


        $aboutpage = About::find(1);    //database ees data awahad ingej duudna


        return view('frontend.about_page', compact('aboutpage'));
     }

     public function AboutMultiImage()
     {
        return view('admin.about_page.multimage');
     }


//method ni route deer post baiwal Request $request -iig ashiglana
public function StoreMultiImage(Request $request)
{
    $images = $request->file('multi_image');

    if (!empty($images)) {
        $manager = new ImageManager(new Driver());

        foreach ($images as $multi_image) {
            $name_gen = uniqid() . '.' . $multi_image->getClientOriginalExtension();
            $img = $manager->read($multi_image);
            $img = $img->resize(220, 220);
            $img->toJpeg(80)->save(base_path('public/upload/multi/' . $name_gen));

            $save_url = 'upload/multi/' . $name_gen;

            MultiImage::insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Multi Image Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($notification);
    }



}
public function AllMultiImage()
{
    //multiimage deh bvh data duudaj baina teriigee compact-aar viewlvv ywuulj bna
    $allMultiImage=MultiImage::all();
    return view('admin.about_page.all_multiimage' , compact('allMultiImage'));
}

public function EditMultiImage($id)//-end $id parameter iig zaaj ogch baina
{
    $multiImage=MultiImage::findOrFail($id);

    return view('admin.about_page.edit_multi_image', compact('multiImage'));// compactaar multiImage -iig damjuulj baina
}
public function UpdateMultiImage(Request $request)//post bolohoor request ashiglana
{
    $multi_image_id = $request->id;

    if ($request->file('multi_image')) {

        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()).'.'.$request->file('multi_image')->getClientOriginalExtension();  // 3434343443.jpg
        $img=$manager->read($request->file('multi_image'));

        $img=$img->resize(220,220);

        $img->toJpeg(80)->save(base_path('public/upload/multi/'.$name_gen));

        $save_url='upload/multi/'.$name_gen;


        // $image = $request->file('home_slide');

        // Image::make($image)->resize(636,852)->save('upload/home_slide/'.$name_gen);
        // $save_url = 'upload/home_slide/'.$name_gen;

        MultiImage::findOrFail($multi_image_id)->update([

            'multi_imge' => $save_url,

        ]);
        $notification = array(
        'message' => 'Multi Updated with Image Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.multi.image')->with($notification);

    }
}

public function DeleteMultiImage($id)
{   $multi=MultiImage::findOrFail($id);
    $img=$multi->multi_image;
    unlink($img);

    MultiImage::findOrFail($id)->delete();
    $notification = array(
        'message' => 'Deleted  Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
}





}










