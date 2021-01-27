<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [

        'title_uz',
        'title_ru',
        'role_code',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'role', 'id');
    }
}
