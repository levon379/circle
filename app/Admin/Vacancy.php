<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $fillable = ['ordering'];
    protected $table = "vacancy";

}
