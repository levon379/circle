<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected $guarded = [];
    protected $fillable = ['ordering'];
    protected $table = "slider";
    public function category()
    {
        return $this->hasOne('App\Admin\Category', "id", "category_id");
    }
}
