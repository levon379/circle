<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class BlogScheme extends Model
{
    protected $table = "blog_scheme";
    public $fillable = ['cols', 'description', 'title', 'parent_id', 'image_id'];

    public function blogImage()
    {
        return $this->hasOne('App\Admin\BlogImage', "id", "image_id")->where('is_background',0);
    }

    public function blogBackground()
    {
        return $this->hasOne('App\Admin\BlogImage', "id", "image_id")->where('is_background',1);
    }

    public function subs()
    {
        return $this->hasMany('App\Admin\BlogScheme', "parent_id", "id");
    }
}
