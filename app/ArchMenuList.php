<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchMenuList extends Model
{
    //
    protected $fillable = [
        'title_uz',
        'title_ru',
        'sort',
        'role',
        'status'
    ];
}
