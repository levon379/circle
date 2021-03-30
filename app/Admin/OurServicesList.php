<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class OurServicesList extends Model
{
    protected $table = "our_services_list";

    public function our_services_list_item()
    {
        return $this->hasMany('App\Admin\OurServicesListItem', "our_services_list_id", "id");
    }
}
