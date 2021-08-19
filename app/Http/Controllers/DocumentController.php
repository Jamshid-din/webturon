<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ArchMenuList;
use App\SubArchMenuList;
use App\DocumentList;
use App\PersonalList;
use App\DocFile;
use Response;
class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
        $menu = ArchMenuList::where('role', '0')->where('status', 1)->where('parent_id', 0)->orderBy('sort', 'ASC')->get();

 
        return view('components.docs',compact('menu'));
    }

    public function fetchChild($id)
    {
  
        $submenu = ArchMenuList::where('role', '0')->where('status', 1)->where('parent_id', $id)->orderBy('sort', 'ASC')->get();
 
        return response()->json(['success' => true, 'sub_menu' => $submenu]);  
    }

    public function fetchData(Request $request){
        
        $sub_id = $request->input('id');
        switch ($sub_id) {
            case 0:
                $models = DB::table('document_lists as a')
                ->leftJoin('doc_files as b', 'a.doc_file_id','=','b.id')
                ->leftJoin('doc_files as d', 'a.doc_e_file_id','=','d.id')
                ->select('a.*','b.doc_name','d.doc_name as e_doc_name')
                ->where('a.status', 1)
                ->take(25)
                ->get(); 
                break;
            
            default:
                $models = DB::table('document_lists as a')
                ->leftJoin('doc_files as b', 'a.doc_file_id','=','b.id')
                ->leftJoin('doc_files as d', 'a.doc_e_file_id','=','d.id')
                ->select('a.*','b.doc_name','d.doc_name as e_doc_name')
                ->where('a.doc_menu_id', $sub_id)
                ->where('a.status', 1)
                ->get();                
                break;
            }
        

        return response()->json(array('success' => true, 'Sub_Dep_Id' => $sub_id, 'msg' => $models));  
    }

    public function download($id)
    {
        $model = DocFile::find($id);

        if($model){
            $url = public_path()."/storage/archive/".$model->doc_hash;


            if (file_exists($url)) {
    
                return Response::download($url,$model->doc_name);
    
            } else {
    
                return back()->with('notFiles', 'Serverdan fayllar topilmadi!');
            }
        }
        return back()->with('notFiles', 'Serverdan fayllar topilmadi!');

    }

}
