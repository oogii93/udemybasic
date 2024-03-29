<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function AllBlogCategory()
    {
         //db bvh datag awch bna
         $blogcategory= BlogCategory::latest()->get();
         //awsan datagaa ene url rvv compactaar shiljvvlj baina
         return view('admin.blog_category.blog_category_all',compact('blogcategory'));
    }

    public function AddBlogCategory()
    {



        return view('admin.blog_category.blog_category_add');


    }

    public function StoreBlogCategory(Request $request)
    {
        $request->validate([
            'blog_category'=>'required',


        ],
    [   //validation buruu bolson ved garch ireh message  error meessage

        'blog_category.required'=>'Blog Category Name is Required',


    ]);





    BlogCategory::insert([
        'blog_category' => $request->blog_category,


    ]);
    $notification = array(
    'message' => 'blog inserted with Image Successfully',
    'alert-type' => 'success'
);

    return redirect()->route('all.blog.category')->with($notification);
    }

   public function EditBlogCategory($id)
   {
    $blogcategory =BlogCategory::findOrFail($id);



    return view('admin.blog_category.blog_category_edit' ,compact('blogcategory'));
   }

   public function UpdateBlogCategory(Request $request, $id)
   {


    BlogCategory::findOrFail($id)->update([
        'blog_category' => $request->blog_category,


    ]);
    $notification = array(
    'message' => 'blog updated   Successfully',
    'alert-type' => 'success'
);

    return redirect()->route('all.blog.category')->with($notification);

   }

   public function DeleteBlogCategory($id)
   {



    $blogcategory =
            BlogCategory::findOrFail($id)->delete();

            $notification =array(
                'message'=>'Blog category deleted successfully',
                'alert-type'=>'success'

            );
            return redirect()->back()->with($notification);


   }





 }



