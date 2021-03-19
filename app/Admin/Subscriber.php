<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscriber';
    protected $fillable = ['email'];

    protected $guarded = [];
}
