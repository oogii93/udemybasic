<?php

namespace App\Http\Controllers\Home;

use Image;
use Carbon\Carbon;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PortfolioController extends Controller
{
    public function AllPortfolio()
    {
        //db bvh datag awch bna
        $portfolio= Portfolio::latest()->get();
        //awsan datagaa ene url rvv compactaar shiljvvlj baina
        return view('admin.portfolio.portfolio_all',compact('portfolio'));
    }

    public function AddPortfolio()
    {
        return view('admin.portfolio.portfolio_add');
    }

    public function StorePortfolio(Request $request)//POst bol zaawal request baina
    {
        //validation hiih

        $request->validate([
            'portfolio_name'=>'required',
            'portfolio_title'=>'required',
            'portfolio_image'=>'required',

        ],
    [   //validation buruu bolson ved garch ireh message  error meessage

        'portfolio_name.required'=>'Portfolio Name is Required',
        'portfolio_title.required'=>'Portfolio Title is Required',
        'portfolio_image.required'=>'Portfolio Image is Required',

    ]);

    $manager = new ImageManager(new Driver());
    $name_gen = hexdec(uniqid()).'.'.$request->file('portfolio_image')->getClientOriginalExtension();  // 3434343443.jpg
    $img=$manager->read($request->file('portfolio_image'));

    $img=$img->resize(1020,519);

    $img->toJpeg(80)->save(base_path('public/upload/portfolio/'.$name_gen));

    $save_url='upload/portfolio/'.$name_gen;




    Portfolio::insert([
        'portfolio_name' => $request->portfolio_name,
        'portfolio_title' => $request->portfolio_title,
        'portfolio_description' => $request->portfolio_description,
        'portfolio_image' => $save_url,
        'created_at'=>Carbon::now(),

    ]);
    $notification = array(
    'message' => 'Portfolio inserted with Image Successfully',
    'alert-type' => 'success'
);

    return redirect()->route('all.portfolio')->with($notification);
    }



    public function EditPortfolio($id)//id gaar ni olj baiga bolohoor haaltan dotor $id oruulj ogch baina
    {
        $portfolio =Portfolio::findOrFail($id);



        return view('admin.portfolio.portfolio_edit' ,compact('portfolio'));

    }

    public function UpdatePortfolio(Request $request)

    {




            $portfolio_id = $request->id;

            if ($request->file('portfolio_image')) {

                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$request->file('portfolio_image')->getClientOriginalExtension();  // 3434343443.jpg
                $img=$manager->read($request->file('portfolio_image'));

                $img=$img->resize(1020,519);

                $img->toJpeg(80)->save(base_path('public/upload/portfolio/'.$name_gen));

                $save_url='upload/portfolio/'.$name_gen;




                Portfolio::findOrFail($portfolio_id)->update([
                    'portfolio_name' => $request->portfolio_name,
                    'portfolio_title' => $request->portfolio_title,
                    'portfolio_description' => $request->portfolio_description,
                    'portfolio_image' => $save_url,

                ]);
                $notification = array(
                'message' => 'Portfolio Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio')->with($notification);

            } else{

                Portfolio::findOrFail($portfolio_id)->update([
                    'portfolio_name' => $request->portfolio_name,
                    'portfolio_title' => $request->portfolio_title,
                    'portfolio_description' => $request->portfolio_description,
                ]);
                $notification = array(
                'message' => 'Portfolio Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio')->with($notification);

            } // end Else

         } // End Method

         public function DeletePortfolio($id)//tvrvvn id {id} gesen bolohoor end bas $id variable -eer olj baina
         {
            $portfolio=Portfolio::findOrFail($id);
            $img=$portfolio->portfolio_image;
            unlink($img);

            Portfolio::findOrFail($id)->delete();

            $notification =array(
                'message'=>'Portfolio Image deleted successfully',
                'alert-type'=>'success'

            );
            return redirect()->back()->with($notification);

         }


         //
         public function PortfolioDetails($id)
         {

            $portfolio =Portfolio::findOrFail($id);
            return view('frontend.portfolio_details' ,compact('portfolio'));


         }



    }



