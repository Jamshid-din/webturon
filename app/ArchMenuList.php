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
        $menus = ArchMenuList::where('role', 0)->get();
        $key2 = 0;

        while($id != 0) {
            foreach ($menus as $key => $value) {
                if($id == $value->id) {
                    $str = $value->title_uz.' -> '.$str;
                    $id = $value->parent_id;
                    break;
                } 
                $key2 = $key;
            }
            if($key2 + 1 == $menus->count()) {
                print_r('Not found');
                break;
            }
        }
        return $str;
    }

    public function parentsPersonal($id)
    {
        $str = "";
        $menus = ArchMenuList::where('role', 1)->get();
        $key2 = 0;

        while($id != 0) {
            foreach ($menus as $key => $value) {
                if($id == $value->id) {
                    $str = $value->title_uz.' -> '.$str;
                    $id = $value->parent_id;
                    break;
                } 
                $key2 = $key;
            }
            if($key2 + 1 == $menus->count()) {
                print_r('Not found');
                break;
            }
        }
        return $str;
    }

    public function parentsInverseArr($id)
    {
        $arr = [];
        $menus = ArchMenuList::where('role', 0)->get();
        $checkId = ArchMenuList::where('id', $id)->get();
        $key2 = 0;

        while($checkId->parent_id != 0) {
            foreach ($menus as $key => $value) {
                if($id == $value->parent_id) {
                    array_push($arr, $value->id);
                    $id = $value->id;
                    $checkId = ArchMenuList::where('id', $id)->get();
                    break;
                } 
                $key2 = $key;
            }
            if($key2 + 1 == $menus->count()) {
                print_r('Not found');
                break;
            }
        }
        return $arr;
    }

}
