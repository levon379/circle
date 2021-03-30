<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class OurWorks extends Model
{
    protected $table = "our_works";
    public static $category = [
        'branding'=>'Branding', 'technical'=>'Technical', 'interior'=>'Interior'
    ];
}
