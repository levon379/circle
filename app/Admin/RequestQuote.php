<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class RequestQuote extends Model
{
    protected $table = "request_quote";
    public function image()
    {
        return $this->hasMany('App\Admin\RequestQuoteImage', "request_quotes_id", "id");
    }

}
