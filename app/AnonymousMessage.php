<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnonymousMessage extends Model
{
    //
    protected $fillable = [
        'title',
        'text',
        'ip_address',
        'status'
    ];
}
