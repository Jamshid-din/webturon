<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\PersonalList;
use App\ArchMenuList;
use App\DepartList;
use App\SubDepartList;
use App\DocumentList;
use App\DocFile;
use App\IpList;
use App\SoftMenu;
use App\SoftList;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public bool $isFinish = false;

    // Archive Menu
    public function archIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "metodologiya"){
            abort(404);
        } 

        $menuType = 'parent';
        $parent =  ArchMenuList::where('role', 0)->orderBy('created_at', 'DESC')->get();

        if($request->input()) {

            $parentId   = $request->input(['parent']);
            $title_uz   = $request->input(['title_uz']);
            $title_ru   = $request->input(['title_ru']);
            $sort       = $request->input(['sort']);
            $status     = $request->input(['status']);

            $search = ArchMenuList::where('role', 0)->orderBy('created_at', 'DESC');

            if($parentId)       $search->where('parent_id', $parentId);

            if($title_uz) $search->where('title_uz', 'like', '%'. $title_uz .'%');

            if($title_ru) $search->where('title_ru', 'like', '%'.$title_ru.'%');

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);

            $models->appends ( array (
                'parent'    => $parentId,
                'title_uz'  => $title_uz,
                'title_ru'  => $title_ru,
                'sort'      => $sort,
                'status'    => $status
            ));

            return view('admin.menus.menu-archive.index',compact('models', 'menuType', 'parent', 'parentId', 'title_uz','title_ru','sort','status', 'parent'));
        } 
        else{
            $models =  ArchMenuList::where('role', 0)->orderBy('created_at', 'DESC')->paginate(10);

            // dd($parent);
            // foreach ($parent as $key => $value) {
            //     print_r($value."<br>");
            // }die;
            return view('admin.menus.menu-archive.index',compact('models', 'menuType', 'parent'));
        }


    }

    public function archSubIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "hr"){
            abort(404);
        } 

        $menuType = 'child';
        $parent = ArchMenuList::where('role', 0)->where('parent_id', 0)->orderBy('sort', 'ASC')->get();
        
        if($request->input()) {
            
            $parentId   = $request->input(['parent']);
            $title_uz   = $request->input(['title_uz']);
            $title_ru   = $request->input(['title_ru']);
            $sort       = $request->input(['sort']);
            $status     = $request->input(['status']);
            $role     = $request->input(['role']);
            $sort     = $request->input(['sort']);

            $currentMenu = ArchMenuList::where('role', 0)->where('id', $parentId)->first();

            $search = ArchMenuList::where('role', 0);

            if($parentId)       $search->where('parent_id', $parentId);

            if($title_uz)       $search->where('title_uz', 'like', '%'. $title_uz .'%');

            if($title_ru)       $search->where('title_ru', 'like', '%'.$title_ru.'%');

            if($status != null) $search->where('status', $status);

            if($role != null) $search->where('role', $role);

            if($sort != null) $search->where('sort', $status);


            $models = $search->orderBy('created_at', 'DESC')->paginate(10);

            $models->appends ( array (
                'parent'    => $parentId,
                'title_uz'  => $title_uz,
                'title_ru'  => $title_ru,
                'sort'      => $sort,
                'status'    => $status,
                'role'      => $role
            ));
            
            return view('admin.menus.menu-archive.index-sub',compact('models','menuType','currentMenu','parent','parentId','title_uz','title_ru','sort','status', 'role'));

        }

        $models = ArchMenuList::where('role', 0)
        ->orderBy('created_at', 'DESC')
        ->paginate(10); 

        return view('admin.menus.menu-archive.index-sub',compact('models', 'menuType','parent'));
    }

    public function archMenuStore(Request $request){
        
        $this->validate($request, [
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);

        $new = new ArchMenuList();
        $new->parent_id = $request->input("parent") ? $request->input("parent") : 0;
        $new->title_uz = $request->input('title_uz');
        $new->title_ru = $request->input('title_ru');
        $new->sort     = $request->input('sort');
        $new->role     = 0;
        $new->status   = $request->input('status');
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

    public function archSubStore(Request $request){

        $this->validate($request, [
            'parent'     => 'required',
            'title_uz'      => 'required',
            'title_ru'       => 'required',
            'status'        => 'required',
        ]);

        $new = new ArchMenuList();
        $new->parent_id     = $request->input("parent");
        $new->title_uz      = $request->input("title_uz");
        $new->title_ru      = $request->input("title_ru");
        $new->status        = $request->input("status");
        $new->role          = 0;
        $new->sort          = 0; 
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

    public function archMenuOld($id){

        $model = ArchMenuList::findOrFail($id);

        return response()->json(['oldMenu' => $model]);
    }

    public function archSubMenuOld($id){
        $model = SubArchMenuList::findOrFail($id);

        return response()->json(['oldSubMenu' => $model]);
    }
    
    public function archMenuUpdate(Request $request){

        $this->validate($request, [
            'parent'    => 'required',
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);


        
        $id = $request->input('id');
        
        if($id == $request->input('parent')){
            return back()->with('error', 'Child can not be child of itself');
        }
        
        $update = ArchMenuList::find($id);

        $update->update([
            'title_uz'  => $request->input('title_uz'),
            'title_ru'  => $request->input('title_ru'),
            'sort'      => $request->input('sort'),
            'status'    => $request->input('status'),
            'parent_id'  => $request->input('parent'),
        ]);
        
        return back()->with('success', 'Successfully updated');
    }

    public function archSubUpdate(Request $request){

        $this->validate($request, [
            'parent'    => 'required',
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'status'    => 'required',
        ]);

        $id = $request->input('id');

        $update = SubArchMenuList::find($id);

        $update->update([
            'title_uz'      => $request->input('title_uz'),
            'title_ru'      => $request->input('title_ru'),
            'arch_menu_id'  => $request->input('parent'),
            'status'        => $request->input('status')
        ]);
        
        $updateDocumentListArchMenuId = DocumentList::where('doc_sub_arch_menu_id', $id)->update(['doc_arch_menu_id'=>$request->input('parent')]);
        
        return back()->with('success', 'Successfully updated');
    }

    public function archMenuDelete($id){

        $model = ArchMenuList::findOrFail($id);
        $sub_model = ArchMenuList::where('parent_id', $id)->get();
        $doc_model = DocumentList::where('doc_menu_id', $id)->get();
        $canBeDeleted = true;
        $arr = [];
        $menus = ArchMenuList::where('role', 0)->get();

        $childCheck = ArchMenuList::where('parent_id', $model->id)->get();

        if(!($childCheck->count())) {
            $docCheck = DocumentList::where('doc_menu_id', $model->id)->get();            
            if(!($docCheck->count())) {
                $model->delete();
                return response()->json(['success' => true, 'message'=>'Successfully deleted!']);
            } else {
                return response()->json(['success' => false, 'message'=>'Failed to delete. It has documents']);
            }
        } else {
            return response()->json(['success' => false, 'message'=>'Failed to delete. It has child menus']);
        }
    }

    public function getArchSubMenu($id){
        
        $sub_menu = ArchMenuList::where('parent_id', $id)->orderBy('id', 'ASC')->get();

        return response()->json(['sub_menu' => $sub_menu]);
    }    

    public function getArchParentSubMenu($parent_id){
        
        $sub_menu = ArchMenuList::find($parent_id)->orderBy('id', 'ASC')->get();

        return response()->json(['sub_menu' => $sub_menu]);
    }


    // Personal Menu
    public function personalIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "hr"){
            abort(404);
        } 

        $menuType = 'parent';

        if($request->input()) {

            $title_uz   = $request->input(['title_uz']);
            $title_ru   = $request->input(['title_ru']);
            $sort       = $request->input(['sort']);
            $status     = $request->input(['status']);

            $search = ArchMenuList::where('role', 1)->orderBy('sort', 'asc');

            if($title_uz) $search->where('title_uz', 'like', '%'. $title_uz .'%');

            if($title_ru) $search->where('title_ru', 'like', '%'.$title_ru.'%');

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);

            $models->appends ( array (
                'title_uz'  => $title_uz,
                'title_ru'  => $title_ru,
                'sort'      => $sort,
                'status'    => $status
            ));


            return view('admin.menus.menu-personal.index',compact('models', 'menuType','title_uz','title_ru','sort','status'));
        } 
        else{
            $models = ArchMenuList::where('role', 1)->orderBy('sort', 'asc')->paginate(10);

            return view('admin.menus.menu-personal.index',compact('models', 'menuType'));
        }
    }

    public function personalStore(Request $request){

        $this->validate($request, [
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);

        $new = new ArchMenuList();
        $new->title_uz = $request->input('title_uz');
        $new->title_ru = $request->input('title_ru');
        $new->sort     = $request->input('sort');
        $new->role     = 1;
        $new->status   = $request->input('status');
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

    public function personalUpdate(Request $request){

        $this->validate($request, [
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);

        $id = $request->input('id');

        $update = ArchMenuList::find($id);

        $update->update([
            'title_uz'  => $request->input('title_uz'),
            'title_ru'  => $request->input('title_ru'),
            'sort'      => $request->input('sort'),
            'status'    => $request->input('status')
        ]);
        
        return back()->with('success', 'Successfully updated');
    }

    public function personalDelete($id){

        $model = ArchMenuList::findOrFail($id);
        $sub_model = SubArchMenuList::where('arch_menu_id', $id)->get();
        $personal_model = PersonalList::where('doc_arch_menu_id', $id)->get();
        foreach ($personal_model as $key => $value) {

            $scanFile = DocFile::find($value->doc_file_id);
            $electronicFile = DocFile::find($value->doc_e_file_id);
            
            if($scanFile){
                $file_exists = Storage::disk('public')->exists( '/personal/'.$scanFile->doc_hash );
                if($file_exists){
                    Storage::delete('public/personal/'.$scanFile->doc_hash);
                }
                $scanFile->delete();   
            }
            if($electronicFile){
                $file_exists = Storage::disk('public')->exists( '/personal/'.$electronicFile->doc_hash );
                if($file_exists){
                    Storage::delete('public/personal/'.$electronicFile->doc_hash);
                }
                $electronicFile->delete();   
            }
            if($sub_model->count())      SubArchMenuList::where('arch_menu_id', $id)->delete();
            if($personal_model->count()) PersonalList::where('doc_arch_menu_id', $id)->delete();
        }

        $model->delete();
        
        return response('The record deleted successfully', 200);
    }

    public function personalMenuOld($id){
        $model = ArchMenuList::findOrFail($id);

        return response()->json(['oldMenu' => $model]);
    }


    public function personalSubIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "metodologiya"){
            abort(404);
        } 

        $menuType = 'child';
        $parent = ArchMenuList::where('role', 1)->orderBy('sort', 'ASC')->get();
        if($request->input()) {
            
            $parentId   = $request->input(['parent']);
            $title_uz   = $request->input(['title_uz']);
            $title_ru   = $request->input(['title_ru']);
            $sort       = $request->input(['sort']);
            $status     = $request->input(['status']);

            $currentMenu = ArchMenuList::where('role', 1)->where('id', $parentId)->first();

            if($parentId)       $currentMenu->where('arch_menu_id', $parentId);

            if($title_uz)       $currentMenu->where('title_uz', 'like', '%'. $title_uz .'%');

            if($title_ru)       $currentMenu->where('title_ru', 'like', '%'.$title_ru.'%');

            if($status != null) $currentMenu->where('status', $status);

            $models = $currentMenu->orderBy('created_at', 'DESC')->paginate(10);

            $models->appends ( array (
                'parent'    => $parentId,
                'title_uz'  => $title_uz,
                'title_ru'  => $title_ru,
                'sort'      => $sort,
                'status'    => $status
            ));
            
            return view('admin.menus.menu-personal.index-sub',compact('models','menuType','currentMenu','parent','parentId','title_uz','title_ru','sort','status'));

        }

        $models = ArchMenuList::where('role', 1)
        ->orderBy('created_at', 'DESC')
        ->paginate(10); 

        return view('admin.menus.menu-personal.index-sub',compact('models', 'menuType','parent'));
    }

    public function personalSubStore(Request $request){

        $this->validate($request, [
            'parent'     => 'required',
            'title_uz'      => 'required',
            'title_ru'       => 'required',
            'status'        => 'required',
        ]);

        $new = new SubArchMenuList();
        $new->arch_menu_id  = $request->input("parent");
        $new->title_uz      = $request->input("title_uz");
        $new->title_ru      = $request->input("title_ru");
        $new->status        = $request->input("status");
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

    public function personalSubUpdate(Request $request){
 
        $this->validate($request, [
            'parent'    => 'required',
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'status'    => 'required',
        ]);

        $id = $request->input('id');

        $update = SubArchMenuList::find($id);

        $update->update([
            'title_uz'      => $request->input('title_uz'),
            'title_ru'      => $request->input('title_ru'),
            'arch_menu_id'  => $request->input('parent'),
            'status'        => $request->input('status')
        ]);
        
        $updatePersonalListMenuId = PersonalList::where('doc_sub_arch_menu_id', $id)->update(['doc_arch_menu_id'=>$request->input('parent')]);
        
        return back()->with('success', 'Successfully updated');
    }

    public function personalSubDelete($id){

        $model = SubArchMenuList::findOrFail($id);
        $personal_model = PersonalList::where('doc_sub_arch_menu_id', $id)->get();
        
        foreach ($personal_model as $key => $value) {
            # code...
            $scanFile = DocFile::find($value->doc_file_id);
            $electronicFile = DocFile::find($value->doc_e_file_id);
            
            if($scanFile){
                $file_exists = Storage::disk('public')->exists( '/personal/'.$scanFile->doc_hash );
                if($file_exists){
                    Storage::delete('public/personal/'.$scanFile->doc_hash);
                }
                $scanFile->delete();   
            }
            if($electronicFile){
                $file_exists = Storage::disk('public')->exists( '/personal/'.$electronicFile->doc_hash );
                if($file_exists){
                    Storage::delete('public/personal/'.$electronicFile->doc_hash);
                }
                $electronicFile->delete();   
            }
            if($personal_model->count()) PersonalList::where('doc_sub_arch_menu_id', $id)->delete();
        
        }
        
        $model->delete();

        
        return response('The record deleted successfully', 200);
    }

    public function personalSubMenuOld($id){
        $model = SubArchMenuList::findOrFail($id);

        return response()->json(['oldSubMenu' => $model]);
    }

    public function getPersonalSubMenu($id){
        $sub_menu = SubArchMenuList::where('arch_menu_id', $id)->orderBy('id', 'ASC')->get();
        return response()->json(['sub_menu' => $sub_menu]);
    }

    // Department Menu
    public function depIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin"){
            abort(404);
        } 

        $menuType = 'parent';

        if($request->input()) {

            $title_uz   = $request->input(['title_uz']);
            $title_ru   = $request->input(['title_ru']);
            $sort       = $request->input(['sort']);
            $status     = $request->input(['status']);

            $search = DepartList::orderBy('sort', 'asc');

            if($title_uz) $search->where('title_uz', 'like', '%'. $title_uz .'%');

            if($title_ru) $search->where('title_ru', 'like', '%'.$title_ru.'%');

            if($sort) $search->where('sort', $sort);

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);

            $models->appends ( array (
                'title_uz'  => $title_uz,
                'title_ru'  => $title_ru,
                'sort'      => $sort,
                'status'    => $status
            ));

            return view('admin.menus.menu-dep.index',compact('models', 'menuType','title_uz','title_ru','sort','status'));
        } 
        else{
            $models = DepartList::orderBy('sort', 'asc')->paginate(10);

            return view('admin.menus.menu-dep.index',compact('models', 'menuType'));
        }
    }

    public function depStore(Request $request){
        
        $this->validate($request, [
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);

        $new                = new DepartList();
        $new->bank_user_id  = Auth::id();
        $new->title_uz      = $request->input('title_uz');
        $new->title_ru      = $request->input('title_ru');
        $new->sort          = $request->input('sort');
        $new->status        = $request->input('status');
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

    public function depUpdate(Request $request){
        
        $this->validate($request, [
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);

        $id = $request->input('id');

        $update = DepartList::find($id);

        $update->update([
            'bank_user_id'  => Auth::id(),
            'title_uz'      => $request->input('title_uz'),
            'title_ru'      => $request->input('title_ru'),
            'sort'          => $request->input('sort'),
            'status'        => $request->input('status')
        ]);
        
        return back()->with('success', 'Successfully updated');
    }

    public function depDelete($id){
        $model      = DepartList::find($id);
        $sub_model  = SubDepartList::where('depart_id', $id)->get();
        $ip_model   = IpList::where('depart_id', $id)->get();

        if($sub_model->count()) SubDepartList::where('depart_id', $id)->delete();
        if($ip_model->count())  IpList::where('depart_id', $id)->delete();
        
        if($model){            
            $model->delete();
        }
        else{
            return response('Sorry document Not FOUND.', 200);
        }
        
        return response('The record deleted successfully', 200);
    }

    public function depMenuOld($id){
        $model = DepartList::findOrFail($id);

        return response()->json(['oldMenu' => $model]);
    }

    public function depSubIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin"){
            abort(404);
        } 


        $menuType = 'child';
        $parent = DepartList::orderBy('sort', 'ASC')->get();
        if($request->input()) {
            
            $parentId   = $request->input(['parent']);
            $title_uz   = $request->input(['title_uz']);
            $title_ru   = $request->input(['title_ru']);
            $sort       = $request->input(['sort']);
            $status     = $request->input(['status']);

            $currentMenu = DepartList::find($parentId);

            $search = SubDepartList::orderBy('sort', 'ASC');

            if($parentId)       $search->where('depart_id', $parentId);

            if($title_uz)       $search->where('title_uz', 'like', '%'. $title_uz .'%');

            if($title_ru)       $search->where('title_ru', 'like', '%'.$title_ru.'%');

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);

            $models->appends ( array (
                'parent'    => $parentId,
                'title_uz'  => $title_uz,
                'title_ru'  => $title_ru,
                'sort'      => $sort,
                'status'    => $status
            ));
            
            return view('admin.menus.menu-dep.index-sub',compact('models','menuType','currentMenu','parent','parentId','title_uz','title_ru','sort','status'));
        }

        $models = SubDepartList::orderBy('sort', 'DESC')->paginate(10); 

        return view('admin.menus.menu-dep.index-sub',compact('models', 'menuType','parent'));
    }

    public function depSubStore(Request $request){

        $this->validate($request, [
            'parent'    => 'required',
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);

        $new                = new SubDepartList();
        $new->bank_user_id  = Auth::id();
        $new->depart_id     = $request->input("parent");
        $new->title_uz      = $request->input("title_uz");
        $new->title_ru      = $request->input("title_ru");
        $new->sort          = $request->input("sort");
        $new->status        = $request->input("status");
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

    public function depSubUpdate(Request $request){
 
        $this->validate($request, [
            'parent'    => 'required',
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'sort'      => 'required',
            'status'    => 'required',
        ]);

        $id = $request->input('id');

        $update = SubDepartList::find($id);

        $update->update([
            'bank_user_id'  => Auth::id(),
            'title_uz'      => $request->input('title_uz'),
            'title_ru'      => $request->input('title_ru'),
            'depart_id'     => $request->input('parent'),
            'sort'          => $request->input('sort'),
            'status'        => $request->input('status')
        ]);
        
        $updateIpListDepartId = IpList::where('sub_depart_id', $id)->update(['depart_id'=>$request->input('parent')]);
        
        return back()->with('success', 'Successfully updated');
    }

    public function depSubDelete($id){
        $model = SubDepartList::find($id);
        $ip_list_model = IpList::where('sub_depart_id', $id)->get();
        
        if($ip_list_model->count()) IpList::where('sub_depart_id', $id)->delete();

        if($model){
            $model->delete();
        }
        else{
            return response('Sorry document Not FOUND.', 200);
        }
        
        return response('The record deleted successfully', 200);
    }

    public function depSubMenuOld($id){
        $model = SubDepartList::findOrFail($id);

        return response()->json(['oldSubMenu' => $model]);
    }

    // Soft Menu
    public function softIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin"){
            abort(404);
        } 
        if($request->input()) {

            $title_uz   = $request->input(['title_uz']);
            $title_ru   = $request->input(['title_ru']);
            $sort       = $request->input(['sort']);
            $status     = $request->input(['status']);

            $search = SoftMenu::orderBy('sort', 'asc');

            if($title_uz) $search->where('title_uz', 'like', '%'. $title_uz .'%');

            if($title_ru) $search->where('title_ru', 'like', '%'.$title_ru.'%');

            if($sort) $search->where('sort', $sort);

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);

            $models->appends ( array (
                'title_uz'  => $title_uz,
                'title_ru'  => $title_ru,
                'sort'      => $sort,
                'status'    => $status
            ));

            return view('admin.menus.menu-soft.index',compact('models','title_uz','title_ru','sort','status'));
        } 
        else{
            $models = SoftMenu::orderBy('sort', 'asc')->paginate(10);

            return view('admin.menus.menu-soft.index',compact('models'));
        }
 
    }

    public function softStore(Request $request)
    {
        # code...
        $this->validate($request,[
            'title_uz',
            'title_ru',
            'sort',
            'status',
        ]);
        $new            = new SoftMenu();
        $new->user_id   = Auth::id();
        $new->title_uz  = $request->input('title_uz');
        $new->title_ru  = $request->input('title_ru');
        $new->sort      = $request->input('sort');
        $new->status    = $request->input('status');
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

    public function softUpdate(Request $request)
    {
        # code...
        $this->validate($request,[
            'title_uz',
            'title_ru',
            'sort',
            'status',
        ]);
        $id = $request->input('id');
        $update = SoftMenu::findOrFail($id);
        $update->update([
            'user_id'       => Auth::id(),
            'title_uz'      => $request->input('title_uz'),
            'title_ru'      => $request->input('title_ru'),
            'sort'          => $request->input('sort'),
            'status'        => $request->input('status')
        ]);

        return back()->with('success', 'Successfully updated');
    }

    public function softGetOld($id)
    {
        $model = SoftMenu::findOrFail($id);

        return response()->json(['oldMenu' => $model]);
    }

    public function softDestroy($id)
    {
        $model = SoftMenu::findOrFail($id);
        $soft = SoftList::where('menu_id',$model->id)->get();

        if($soft->count()){
            foreach ($soft as $key => $value) {
                
                if(Storage::disk('public')->exists( '/soft/'.$value->hash )){
                    Storage::delete('public/soft/'.$model->hash);
                }

            }
            SoftList::where('menu_id',$model->id)->delete();
        }
        $model->delete();

        return response('The record deleted successfully', 200);
    }

}
