<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoftMenu extends Model
{
    //
    protected $fillable = [
        'user_id',
        'title_uz',
        'title_ru',
        'sort',
        'status'
    ];
}
