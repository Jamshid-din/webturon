<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;

use App\DocumentList;
use App\PersonalList;
use App\ArchMenuList;
use App\SubArchMenuList;
use App\DocFile;



class AdminDocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "metodologiya"){
            abort(404);
        } 

        if($request->input()){
            $menu_id    = $request->input(['menu_id']);
            $sub_menu_id= $request->input(['sub_menu_id']);
            $title  = $request->input(['title']);
            $text   = $request->input(['text']);
            $status = $request->input(['status']);

            $search = DocumentList::orderBy('created_at', 'desc');

            if($menu_id) $search->where('doc_arch_menu_id', $menu_id );
            
            if($sub_menu_id) $search->where('doc_arch_menu_id', $sub_menu_id );

            if($title) $search->where('doc_title', 'like', '%'. $title .'%');

            if($text) $search->where('doc_text', 'like', '%'.$text.'%');

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);
            
            $models->appends ( array (
                'menu_id'       => $menu_id,
                'sub_menu_id'   => $sub_menu_id,
                'title'         => $title,
                'text'          => $text,
                'status'        => $status
            ));

            $menu_list = ArchMenuList::where('role', 0)->get();
            // $sub_menu_list = SubArchMenuList::whereHas('archMenu', function($query){
            //     $query->where('role', 0);
            // })
            // ->where('arch_menu_id',$menu_id)
            // ->orderBy('id', 'DESC')
            // ->get();

            return view('admin.documents.archive.index',compact('models','menu_list','menu_id','sub_menu_id','title','text','status')); 
        }

        $models = DocumentList::orderBy('created_at', 'desc')->paginate(10);
        $menu_list = ArchMenuList::where('role', 0)->orderBy('sort', 'desc')->get();
        // $sub_menu_list = SubArchMenuList::whereHas('archMenu', function($query){
        //     $query->where('role', 0);
        // })
        // ->orderBy('id', 'DESC')->get();

        return view('admin.documents.archive.index',compact('models','menu_list')); 
    }

    public function archStore(Request $request){

        $this->validate($request, [
            'doc_title'     => 'required',
            'doc_text'      => 'required',
            'menu_id'       => 'required',
            'status'        => 'required',
        ]);

        $scanFileId = null;
        $electronicFileId = null;

        if ($request->hasFile('file')){
            $newFile = new DocFile();
            $request->file('file')->store('archive', 'public');

            $newFile->doc_name   = $request->file("file")->getClientOriginalName();
            $newFile->doc_hash   = $request->file('file')->hashName();
            $newFile->doc_ext    = $request->file('file')->extension();
            $newFile->doc_size   = $request->file("file")->getSize();
            $newFile->doc_type   = 'scan';
            $newFile->list_type  = 'document';
            $newFile->status     = 1;
            $newFile->save();
            $scanFileId = $newFile->id;
        }
        if($request->hasFile('e-file')){
            $newElectronicFile = new DocFile();
            $request->file('e-file')->store('archive', 'public');

            $newElectronicFile->doc_name = $request->file("e-file")->getClientOriginalName();
            $newElectronicFile->doc_hash = $request->file("e-file")->hashName();
            $newElectronicFile->doc_ext  = $request->file("e-file")->extension();
            $newElectronicFile->doc_size = $request->file("e-file")->getSize();
            $newElectronicFile->doc_type = 'electronic';
            $newElectronicFile->list_type= 'document';
            $newElectronicFile->status   = 1;
            $newElectronicFile->save();
            $electronicFileId = $newElectronicFile->id;
        }

        $newDoc                         = new DocumentList();
        $newDoc->bank_user_id           = Auth::id();
        $newDoc->doc_title              = $request->input('doc_title');
        $newDoc->doc_text               = $request->input('doc_text');
        $newDoc->doc_arch_menu_id       = $request->input('menu_id');
        $newDoc->doc_menu_id            = $request->input('menu_id');
        $newDoc->doc_file_id            = $scanFileId;
        $newDoc->doc_e_file_id          = $electronicFileId;
        $newDoc->status                 = $request->input('status');
        $newDoc->save();

        return back()->with('success', 'Successfully stored');
    }
    
    public function archUpdate(Request $request){
       
        $id = $request->input('id');
        $update = DocumentList::find($id);

        $scanFileId = $update->doc_file_id;
        $electronicFileId = $update->doc_e_file_id;

        if(!$request->input('filename')){
            if($update->doc_file_id){
                $scanFile = DocFile::find($scanFileId);
                if($scanFile){
                    Storage::delete('public/archive/'.$scanFile->doc_hash);
                    $scanFile->delete();   
                    $scanFileId = null;
                }
            }
        }
        if(!$request->input('e-filename')){
            if($update->doc_e_file_id){
                $electronicFile = DocFile::find($electronicFileId);
                if($electronicFile){
                    Storage::delete('public/archive/'.$electronicFile->doc_hash);
                    $electronicFile->delete();  
                    $electronicFileId = null; 
                }
            }
        }

        if ($request->hasFile('file')){
            $newFile = new DocFile();
            $request->file('file')->store('archive', 'public');

            $newFile->doc_name   = $request->file("file")->getClientOriginalName();
            $newFile->doc_hash   = $request->file('file')->hashName();
            $newFile->doc_ext    = $request->file('file')->extension();
            $newFile->doc_size   = $request->file("file")->getSize();
            $newFile->doc_type   = 'scan';
            $newFile->list_type  = 'document';
            $newFile->save();
            $scanFileId = $newFile->id;
        }
        if($request->hasFile('e-file')){
            $newElectronicFile = new DocFile();
            $request->file('e-file')->store('archive', 'public');

            $newElectronicFile->doc_name = $request->file("e-file")->getClientOriginalName();
            $newElectronicFile->doc_hash = $request->file("e-file")->hashName();
            $newElectronicFile->doc_ext  = $request->file("e-file")->extension();
            $newElectronicFile->doc_size = $request->file("e-file")->getSize();
            $newElectronicFile->doc_type = 'electronic';
            $newElectronicFile->list_type= 'document';
            $newElectronicFile->save();
            $electronicFileId = $newElectronicFile->id;
        }
    
        $update->update([
            'bank_user_id'         => Auth::id(),
            'doc_title'            => $request->input('doc_title'),
            'doc_text'             => $request->input('doc_text'),
            'doc_arch_menu_id'     => $request->input('menu_id'),
            'doc_menu_id'          => $request->input('menu_id'),
            'doc_file_id'          => $scanFileId,
            'doc_e_file_id'        => $electronicFileId,
            'status'               => $request->input('status')
        ]);
        
        return back()->with('success', 'Successfully updated');

    }
    // Get Old info into Update Modal
    public function archGetOld($id){

        $oldArch        = DocumentList::findOrFail($id);
        $scanFile       = DocFile::find( $oldArch->doc_file_id);
        $electronicFile = DocFile::find( $oldArch->doc_e_file_id);
        
        $menu       = ArchMenuList::where('role', 0)->orderBy('sort', 'ASC')->get();
        // $subMenu    = SubArchMenuList::where('arch_menu_id', $oldArch->doc_arch_menu_id)->get();

        return response()->json(['oldArch' => $oldArch, 'scanFile' => $scanFile,'electronicFile' => $electronicFile, 'menu' => $menu]);
    }

    public function archDelete($id){

        $model = DocumentList::find($id);
        if($model){
            $scanFile = DocFile::find($model->doc_file_id);
            $electronicFile = DocFile::find($model->doc_e_file_id);
            if($scanFile){
                Storage::delete('public/archive/'.$scanFile->doc_hash);
                $scanFile->delete();   
            }
            if($electronicFile){
                Storage::delete('public/archive/'.$electronicFile->doc_hash);
                $electronicFile->delete();   
            }
            
            $model->delete();
        }
        else{
            return response('Sorry document Not FOUND.', 200);
        }


        return response('The record deleted successfully.', 200);
    }

    public function personalIndex(Request $request){

        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "hr"){
            abort(404);
        } 

        if($request->input()){

            $menu_id    = $request->input(['menu_id']);
            // $sub_menu_id= $request->input(['menu_id']);
            $title = $request->input(['title']);
            $text = $request->input(['text']);
            $status = $request->input(['status']);

            $search = PersonalList::orderBy('created_at', 'desc');

            if($menu_id) $search->where('doc_arch_menu_id', $menu_id );
            
            if($title) $search->where('doc_title', 'like', '%'. $title .'%');

            if($text) $search->where('doc_text', 'like', '%'.$text.'%');

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);
            $models->appends ( array (
                'menu_id'       => $menu_id,
                'title'         => $title,
                'text'          => $text,
                'status'        => $status
            ));


            $menu_list = ArchMenuList::where('role', 1)->get();
            // $sub_menu_list = SubArchMenuList::whereHas('archMenu', function($query){
            //     $query->where('role', 1);
            // })
            // ->where('arch_menu_id',$menu_id)->orderBy('id', 'DESC')->get();
            

            return view('admin.documents.personal.index',compact('models','menu_list','menu_id','title','text','status')); 
        }

        $models = PersonalList::orderBy('created_at', 'desc')->paginate(10);
        $menu_list = ArchMenuList::where('role', 1)->orderBy('sort', 'desc')->get();
        // $sub_menu_list = SubArchMenuList::whereHas('archMenu', function($query){
        //     $query->where('role', 1);
        // })
        // ->orderBy('id', 'DESC')->get();
        
        return view('admin.documents.personal.index',compact('models','menu_list')); 

    }

    public function personalStore(Request $request){

        $this->validate($request, [
            'doc_title'     => 'required',
            'menu_id'       => 'required',
            // 'sub_menu_id'   => 'required',
            'status'        => 'required',
        ]);

        $scanFileId = null;
        $electronicFileId = null;

        if ($request->hasFile('file')){
            $newFile = new DocFile();
            $request->file('file')->store('personal', 'public');

            $newFile->doc_name   = $request->file("file")->getClientOriginalName();
            $newFile->doc_hash   = $request->file('file')->hashName();
            $newFile->doc_ext    = $request->file('file')->extension();
            $newFile->doc_size   = $request->file("file")->getSize();
            $newFile->list_type  = 'personal';
            $newFile->doc_type   = 'scan';
            $newFile->save();
            $scanFileId = $newFile->id;
        }
        if($request->hasFile('e-file')){
            $newElectronicFile = new DocFile();
            $request->file('e-file')->store('personal', 'public');

            $newElectronicFile->doc_name = $request->file("e-file")->getClientOriginalName();
            $newElectronicFile->doc_hash = $request->file("e-file")->hashName();
            $newElectronicFile->doc_ext  = $request->file("e-file")->extension();
            $newElectronicFile->doc_size = $request->file("e-file")->getSize();
            $newElectronicFile->list_type  = 'personal';
            $newElectronicFile->doc_type = 'electronic';
            $newElectronicFile->save();
            $electronicFileId = $newElectronicFile->id;
        }

        $newDoc                         = new PersonalList();
        $newDoc->bank_user_id           = Auth::id();
        $newDoc->doc_title              = $request->input('doc_title');
        $newDoc->doc_text               = $request->input('doc_text');
        $newDoc->doc_arch_menu_id       = $request->input('menu_id');
        $newDoc->doc_menu_id            = $request->input('menu_id');
        $newDoc->doc_file_id            = $scanFileId;
        $newDoc->doc_e_file_id          = $electronicFileId;
        $newDoc->status                 = $request->input('status');
        $newDoc->save();

        return back()->with('success', 'Successfully stored');
    }

    public function personalUpdate(Request $request){
       
        $id = $request->input('id');
        $update = PersonalList::find($id);

        $scanFileId = $update->doc_file_id;
        $electronicFileId = $update->doc_e_file_id;

        if(!$request->input('filename')){
            if($update->doc_file_id){
                $scanFile = DocFile::find($scanFileId);
                if($scanFile){
                    Storage::delete('public/personal/'.$scanFile->doc_hash);
                    $scanFile->delete();   
                    $scanFileId = null;
                }
            }
        }
        if(!$request->input('e-filename')){
            if($update->doc_e_file_id){
                $electronicFile = DocFile::find($electronicFileId);
                if($electronicFile){
                    Storage::delete('public/personal/'.$electronicFile->doc_hash);
                    $electronicFile->delete();  
                    $electronicFileId = null; 
                }
            }
        }

        if ($request->hasFile('file')){
            $newFile = new DocFile();
            $request->file('file')->store('personal', 'public');

            $newFile->doc_name   = $request->file("file")->getClientOriginalName();
            $newFile->doc_hash   = $request->file('file')->hashName();
            $newFile->doc_ext    = $request->file('file')->extension();
            $newFile->doc_size   = $request->file("file")->getSize();
            $newFile->doc_type   = 'scan';
            $newFile->list_type  = 'personal';
            $newFile->save();
            $scanFileId = $newFile->id;
        }
        if($request->hasFile('e-file')){
            $newElectronicFile = new DocFile();
            $request->file('e-file')->store('personal', 'public');

            $newElectronicFile->doc_name = $request->file("e-file")->getClientOriginalName();
            $newElectronicFile->doc_hash = $request->file("e-file")->hashName();
            $newElectronicFile->doc_ext  = $request->file("e-file")->extension();
            $newElectronicFile->doc_size = $request->file("e-file")->getSize();
            $newElectronicFile->doc_type = 'electronic';
            $newElectronicFile->list_type= 'personal';
            $newElectronicFile->save();
            $electronicFileId = $newElectronicFile->id;
        }
    
        $update->update([
            'bank_user_id'         => Auth::id(),
            'doc_title'            => $request->input('doc_title'),
            'doc_text'             => $request->input('doc_text'),
            'doc_arch_menu_id'     => $request->input('menu_id'),
            'doc_menu_id'          => $request->input('menu_id'),
            'doc_file_id'          => $scanFileId,
            'doc_e_file_id'        => $electronicFileId,
            'status'               => $request->input('status')
        ]);
        return back()->with('success', 'Successfully updated');
    }

    public function personalGetOld($id){
        $oldPersonal    = PersonalList::findOrFail($id);
        $scanFile       = DocFile::find( $oldPersonal->doc_file_id);
        $electronicFile = DocFile::find( $oldPersonal->doc_e_file_id);
        
        $menu       = ArchMenuList::where('role', 1)->orderBy('sort', 'ASC')->get();
        // $subMenu    = SubArchMenuList::where('arch_menu_id', $oldPersonal->doc_arch_menu_id)->get();

        return response()->json(['oldPersonal' => $oldPersonal, 'scanFile' => $scanFile,'electronicFile' => $electronicFile, 'menu' => $menu]);
    }

    public function personalDelete($id){

        $model = PersonalList::findOrFail($id);
        
        $scanFile = DocFile::find($model->doc_file_id);
        $electronicFile = DocFile::find($model->doc_e_file_id);

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

        $model->delete();


        return response('The record deleted successfully.', 200);    
    }   

}
