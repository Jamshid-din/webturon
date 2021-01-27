<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentList extends Model
{
    //
    protected $fillable = [
        'bank_user_id',
        'doc_title',
        'doc_text',
        'doc_arch_menu_id',
        'doc_sub_arch_menu_id',
        'doc_file_id',
        'doc_e_file_id',
        'status',

    ];
}
