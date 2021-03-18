<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class WhyTahweel extends Model
{
    protected $fillable = ['ordering'];
    protected $table = "why_tahweel";
    protected $guarded = [];
}
