<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ArchMenuList;
use App\SubArchMenuList;
use App\DocumentList;
use App\PersonalList;
use App\DocFile;
use Response;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $menu = ArchMenuList::where('parent_id', 0)->where('role', 1)->where('status', 1)->orderBy('sort', 'ASC')->get();
        $sub_menu = ArchMenuList::where('parent_id', '>', 0)->where('role', 1)
        ->where('status', 1)
        ->orderBy('id', 'ASC')
        ->get();

        
        return view('components.staff', compact('menu', 'sub_menu'));
    }

    public function fetchData(Request $request){
        
        $sub_id = $request->input('id');
        switch ($sub_id) {
            case 0:
            case 1:
                $models = DB::table('personal_lists as a')
                ->leftJoin('doc_files as b', 'a.doc_file_id','=','b.id')
                ->leftJoin('doc_files as d', 'a.doc_e_file_id','=','d.id')
                ->select('a.*','b.doc_name','d.doc_name as e_doc_name')
                ->where('a.status', 1)
                ->orderBy('a.created_at', 'DESC')
                ->take(10)
                ->get();  
                break;
            
            default:
                $models = DB::table('personal_lists as a')
                ->leftJoin('doc_files as b', 'a.doc_file_id','=','b.id')
                ->leftJoin('doc_files as d', 'a.doc_e_file_id','=','d.id')
                ->select('a.*','b.doc_name','d.doc_name as e_doc_name')
                ->where('a.doc_menu_id', $sub_id)
                ->where('a.status', 1)
                ->get();
                break;
        }
        

        return response()->json(array('success' => true, 'Sub_Dep_Id' => '', 'msg' => $models));  
    }


    public function download($id)
    {
        $model = DocFile::find($id);

        if($model){
            $url = public_path()."/storage/personal/".$model->doc_hash;


            if (file_exists($url)) {
    
                return Response::download($url,$model->doc_name);
    
            } else {
    
                return back()->with('notFiles', 'Serverdan fayllar topilmadi!');
            }
        }
        return back()->with('notFiles', 'Serverdan fayllar topilmadi!');

    }
}
