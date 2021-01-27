<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpList extends Model
{
    //
    protected $fillable =[
        'bank_user_id',
        'depart_id',
        'sub_depart_id',
        'fio',
        'ip',
        'descr',
        'status'
    ];

    public function department(){

        return $this->belongsTo(DepartList::class,'depart_id');
    }

    public function sub_department(){

        return $this->belongsTo(SubDepartList::class,'sub_depart_id');
    }
}
