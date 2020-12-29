<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscriber';
    const STATUS = [
        'careers' => 1,
        'subscribers' => 2
    ];

    protected $guarded = [];
}
