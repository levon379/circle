<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    const TYPE = [
        'newsletter' => 1,
        'pressRelease' => 2
    ];

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany('App\Admin\MediaImage', "media_id", "id");
    }
}
