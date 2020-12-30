<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class MailContent extends Model
{
    protected $table = 'mail_content';

    protected $guarded = [];

    public static $types = [
        'subscriber' => 'Subscriber',
        'application' => 'Applicaion'
    ];
}
