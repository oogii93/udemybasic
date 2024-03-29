<?php

namespace App\Http\Controllers\Home;

use Image;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{
    public function AllBlog()
    {
        $blogs=Blog::latest()->get();

        return view("admin.blogs.blogs_all", compact("blogs"));
    }

    public function AddBlog()
    {

        $categories=BlogCategory::orderBy('blog_category','ASC')->get();// asc ashiglaad blog_category goos data awch boldog um bna neg turliin holbolt
        return view('admin.blogs.blogs_add' ,compact('categories'));
    }

    public function StoreBlog(Request $request)
    {


        $manager = new ImageManager(new Driver());
    $name_gen = hexdec(uniqid()).'.'.$request->file('blog_image')->getClientOriginalExtension();  // 3434343443.jpg
    $img=$manager->read($request->file('blog_image'));

    $img=$img->resize(430,327);

    $img->toJpeg(80)->save(base_path('public/upload/blog/'.$name_gen));

    $save_url='upload/blog/'.$name_gen;




    Blog::insert([
        'blog_category_id' => $request->blog_category_id,
        'blog_title' => $request->blog_title,
        'blog_description' => $request->blog_description,
        'blog_tags' => $request->blog_tags,
        'blog_image' => $save_url,
        'created_at'=>Carbon::now(),

    ]);
    $notification = array(
    'message' => 'Blog inserted with Image Successfully',
    'alert-type' => 'success'
);

    return redirect()->route('all.blog')->with($notification);
    }

    public function EditBlog($id)
    {

        $blogs=Blog::findOrFail($id);
        $categories=BlogCategory::orderBy('blog_category','ASC')->get();// asc ashiglaad blog_category goos data awch boldog um bna neg turliin holbolt


        return view('admin.blogs.blogs_edit',compact('blogs', 'categories'));

    }
}
