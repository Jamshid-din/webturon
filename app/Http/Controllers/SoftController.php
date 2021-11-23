<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\SoftList;
use App\SoftMenu;


class SoftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGuest()
    {
        $models = SoftList::where('status', 1)->orderBy('created_at')->get();
        $menus = SoftMenu::where('status', 1)->orderBy('sort', 'ASC')->get();

        return view('components.soft', compact('models','menus'));
    }

    public function fetchData($id)
    {
        $models = SoftList::where('status', 1)->where('menu_id', $id)->orderBy('created_at', 'DESC')->paginate(10);

        return response()->json(['models' => $models]);
    }

    
    public function index()
    {
        
        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin" && $current_user_role != "strategy"){
            abort(404);
        } 

 
        
        $models = SoftList::orderBy('created_at', 'DESC')->paginate(10);
        $menu_list = SoftMenu::orderBy('sort', 'ASC')->get();

        return view('admin.soft.index', compact('models','menu_list'));
    }

    public function searchIndex(Request $request)
    {

        # code...
        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin" && $current_user_role != "strategy"){
            abort(404);
        }
        $menu_list = SoftMenu::orderBy('sort', 'ASC')->get();

        if($request->input()) {

            $menu_id   = $request->input(['menu_id']);
            $title  = $request->input(['title']);
            $status = $request->input(['status']);

            $search = SoftList::orderBy('created_at', 'DESC');

            if($menu_id) $search->where('menu_id', $menu_id);

            if($title) $search->where('name', 'like', '%'. $title .'%');

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);

            $models->appends ( array (
                'title'  => $title,
                'menu_id'  => $menu_id,
                'status'    => $status
            ));

            return view('admin.soft.index',compact('models','menu_list','title','menu_id','status'));
        } 
        else{
            $models = SoftList::orderBy('created_at', 'DESC')->paginate(10);

            return view('admin.soft.index',compact('models', 'menu_list'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'menu_id'=> 'required',
            'file'   => 'required',
            'status' => 'required',
        ]);

        $ext = pathinfo($request->file('file'), PATHINFO_EXTENSION);

        if ($request->hasFile('file')){
            $newFile = new SoftList();
            
            $request->file('file')->store('soft', 'public');

            $newFile->user_id = Auth::id();
            $newFile->menu_id = $request->input('menu_id');
            $newFile->name    = $request->file("file")->getClientOriginalName();
            $newFile->hash    = $request->file('file')->hashName();
            $newFile->ext     = $ext;
            $newFile->size    = $request->file("file")->getSize();
            $newFile->status  = $request->input("status");
            $newFile->save();
        }

        return back()->with('success', 'Successfully stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $model = SoftList::findOrFail($id);
        $menu = SoftMenu::find($model->menu_id);

        return response()->json(['model' => $model, 'menu' => $menu]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'id'        => 'required',
            'menu_id'   => 'required',
            'filename'  => 'required',
            'status'    => 'required',
        ]);
        $id = $request->input('id');
        
        $model = SoftList::find($id);

        $file_exists = Storage::disk('public')->exists( '/soft/'.$model->hash );


        if($request->hasFile('file')){
            if(Storage::disk('public')->exists( '/soft/'.$model->hash )){
                Storage::delete('public/soft/'.$model->hash);
            }
            $request->file('file')->store('soft', 'public');

            $model->update([
                'user_id'   => Auth::id(),
                'menu_id'   => $request->input('menu_id'),
                'name'      => $request->file("file")->getClientOriginalName(),
                'hash'      => $request->file("file")->hashName(),
                'ext'       => $request->file("file")->extension(),
                'size'      => $request->file("file")->getSize(),
                'status'    => $request->input("status"),
            ]);
        }else{
            $model->update([
                'user_id'   => Auth::id(),
                'menu_id'   => $request->input('menu_id'),
                'status'    => $request->input('status')
            ]);
        }

        return back()->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $model = SoftList::findOrFail($id);
        if(Storage::disk('public')->exists( '/soft/'.$model->hash )){
            Storage::delete('public/soft/'.$model->hash);
        }
        $model->delete();

        return response('The record deleted successfully.', 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function download($id)
    {
        $model = SoftList::find($id);
        $url = null;
        if($model){
            $url = public_path()."/storage/soft/".$model->hash;

            if (file_exists($url)) {
                return response()->download($url,$model->name);
                return Response::download($url,$model->name);
    
            } else {
    
                return back()->with('notFiles', 'Serverdan fayllar topilmadi!');
            }
        }

        return back()->with('notFiles', 'Serverdan fayllar topilmadi!');

    }
}
