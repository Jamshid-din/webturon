<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoftList extends Model
{
    //
    protected $fillable = [
        'user_id',
        'menu_id',
        'name',
        'hash',
        'ext',
        'size',
        'status',
    ];

    public function softmenu(){
        return $this->belongsTo(SoftMenu::class,'menu_id','id');
    }
}
