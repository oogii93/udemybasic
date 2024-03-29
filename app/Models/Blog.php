<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guardred=[];


    //relation vvsgej baina


    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');// ene realationoor Blogiig Blogcategory toi holboj baina
    }
}
