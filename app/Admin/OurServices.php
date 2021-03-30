<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class OurServices extends Model
{
    protected $table = "our_services";

    public function our_services_list()
    {
        return $this->hasMany('App\Admin\OurServicesList', "our_services_id", "id");
    }
}
