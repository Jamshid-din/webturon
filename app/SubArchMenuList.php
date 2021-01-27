<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubArchMenuList extends Model
{
    //
    protected $fillable = [
        'arch_menu_id',
        'title_uz',
        'title_ru',
        'status'
    ];
    public function archMenu(){
        return $this->belongsTo(ArchMenuList::class,'arch_menu_id','id');
    }
}
