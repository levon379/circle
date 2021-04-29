<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = "blog";
    public $fillable = ['description', 'title'];

    public function blogScheme()
    {
        return $this->hasMany('App\Admin\BlogScheme', "blog_id", "id");
    }
}
