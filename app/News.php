<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $fillable =[
        'user_id',
        'title',
        'text',
        'img_id',
        'status'
    ];

    public function media(){

        return $this->hasOne(MediaFile::class,'id','img_id');
    }
}
