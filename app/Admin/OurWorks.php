<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class OurWorks extends Model
{
    protected $table = "our_works";
    protected $fillable = ['ordering'];
    public static $category = [
        'branding'=>'Branding', 'technical'=>'Technical', 'interior'=>'Interior'
    ];
}
