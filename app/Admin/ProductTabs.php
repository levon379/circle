<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductTabs extends Model
{
   // protected $fillable = ['name'];
    protected $fillable = ['ordering'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tabs_map');
    }
}
