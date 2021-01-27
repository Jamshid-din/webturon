<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocFile extends Model
{
    //
    protected $fillable = [
        'doc_name',
        'doc_hash',
        'doc_ext',
        'doc_size',
        'doc_type',
        'list_type',
        'status',
    ];
}
