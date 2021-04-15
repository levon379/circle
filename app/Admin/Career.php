<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['ordering'];
    protected $table = "careers";

    public function Vacancy()
    {
        return $this->belongsTo('App\Admin\Vacancy', "vacancy_id", "id");
    }
}
