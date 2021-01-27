<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartList extends Model
{
    //
    protected $fillable = [
        'bank_user_id',
        'title_uz',
        'title_ru',
        'status',
        'sort'
    ];

    // public function childs() {

    //     return $this->hasMany('App\Department','parent_id','id')->where('status', 1);

    // }
}
