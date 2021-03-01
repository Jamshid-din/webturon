<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalList extends Model
{
    //
    protected $fillable = [
        'bank_user_id',
        'doc_title',
        'doc_text',
        'doc_arch_menu_id',
        'doc_menu_id',
        'doc_file_id',
        'doc_e_file_id',
        'status',
    ];

    public function file()
    {
        return $this->hasOne(DocFile::class, 'id','doc_file_id');
    }

    public function efile()
    {
        return $this->hasOne(DocFile::class, 'id','doc_e_file_id');
    }

    public function menu(){
        return $this->hasOne(ArchMenuList::class, 'id', 'doc_menu_id');
    }
}
