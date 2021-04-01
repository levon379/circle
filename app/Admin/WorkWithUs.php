<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class WorkWithUs extends Model
{
    protected $table = "work_with_us";
    public function image()
    {
        return $this->hasMany('App\Admin\WorkWIthUsFiles', "work_with_us_id", "id");
    }

}
