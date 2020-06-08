<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo("App\Admin\SpecificationType", "type_id", "id");
    }

}
