<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
    protected $table = "blog_scheme_image";
    public $fillable = ['image_path', 'is_background'];
    public $timestamps = false;
}
