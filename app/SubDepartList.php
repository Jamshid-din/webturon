<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubDepartList extends Model
{
    //
    protected $fillable = [
        'bank_user_id',
        'title_uz',
        'title_ru',
        'depart_id',
        'status',
        'sort'
    ];

    public function parentMenu(){
        return $this->belongsTo(DepartList::class,'depart_id','id');
    }
    
}
