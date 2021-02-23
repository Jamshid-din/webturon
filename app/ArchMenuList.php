<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchMenuList extends Model
{
    //
    protected $fillable = [
        'parent_id',
        'title_uz',
        'title_ru',
        'sort',
        'role',
        'status'
    ];

    public function parent()
    {
        return $this->belongsTo(ArchMenuList::class, 'parent_id', 'id');
    }

    public function parents($id)
    {
        $str = "";

        while($id != 0) {
            $query = ArchMenuList::where('id', $id)->first();
            if($query){
                $str = $query->title_uz.' -> '.$str;
                $id  = $query->parent_id;
            }
            else   break;
            
        }
        return $str;
    }

    public function parentsPersonal($id)
    {
        $str = "";

        while($id != 0) {
            $query = ArchMenuList::where('id', $id)->first();

            if($query){
                $str = $query->title_uz.' -> '.$str;
                $id  = $query->parent_id;
            }
            else    break;

        }
        return $str;
    }

    public function parentsInverseArr($id)
    {
        $checkId = ArchMenuList::where('id', $id)->get();

        $query = ArchMenuList::where('role', 0)->where('parent_id', $checkId->id)->get();
        if($query){
            return false;
        }
        else{
            return true;
        } 

    }

}
