<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\MediaFile;
use App\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $models = News::orderBy('created_at', 'DESC')->paginate(10);
        

        return view('admin.news.index',compact('models'));    
    }

    public function indexSearch(Request $request)
    {
        $title  = $request->input(['title']);
        $status = $request->input(['status']);

        $search = News::orderBy('created_at', 'DESC');

        if($title) $search->where('title', 'like','%'.$title.'%');

        if($status != null) $search->where('status', $status);

        $models = $search->paginate(10);

        $models->appends ( array (
            'title'         => $title,
            'status'        => $status
        ));        

        return view('admin.news.index',compact('models','title','status'));    
    }

    public function guestIndex()
    {
        $models = News::orderBy('created_at', 'DESC')->paginate(6);
        
        return view('components.news',compact('models'));    
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
        $this->validate($request, [
            'title' => 'required',
            'text'  => 'required',
            'file'  => 'required',
            'status'=> 'required',
        ]);

        $file_id = null;

        if ($request->hasFile('file')){
            $newFile = new MediaFile();
            $request->file('file')->store('media', 'public');

            $newFile->user_id= Auth::id();
            $newFile->name   = $request->file("file")->getClientOriginalName();
            $newFile->hash   = $request->file('file')->hashName();
            $newFile->ext    = $request->file('file')->extension();
            $newFile->size   = $request->file("file")->getSize();
            $newFile->save();
            $file_id = $newFile->id;
        }

        $new        = new News();
        $new->title = $request->input('title');
        $new->text  = $request->input('text');
        $new->img_id= $file_id;
        $new->status= $request->input('status');
        $new->save();

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
        $model = News::findOrFail($id);
        $file = MediaFile::find($model->img_id);
        return response()->json(['model' => $model, 'file' => $file]);
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
        $id = $request->input('id');

        $this->validate($request, [
            'id'        => 'required',
            'title'     => 'required',
            'text'      => 'required',
            'filename'  => 'required',
            'status'    => 'required',
        ]);
        
        $model = News::findOrFail($id);
        $file_id = $model->img_id;

        if($request->hasFile('file')){
            $file = MediaFile::find($model->img_id);
            if($file){
                Storage::delete('public/media/'.$file->hash);
                $file->delete();   

                $newFile = new MediaFile();
                $request->file('file')->store('media', 'public');
    
                $newFile->name   = $request->file("file")->getClientOriginalName();
                $newFile->hash   = $request->file('file')->hashName();
                $newFile->ext    = $request->file('file')->extension();
                $newFile->size   = $request->file("file")->getSize();
                $newFile->status = 1;
                $newFile->save();

                $file_id = $newFile->id;
            }
        }

        $model->update([
            'title'  => $request->input('title'),
            'text'   => $request->input('text'),
            'img_id' => $file_id,
            'status' => $request->input('status'),
        ]);

        return back()->with('success', 'Successfully stored');
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
        $model = News::find($id);
        if($model){
            $file = MediaFile::find($model->img_id);
            if($file){
                if (Storage::exists('public/media/'.$file->hash)) {
                    Storage::delete('public/media/'.$file->hash);
                }
                $file->delete();   
            }
    
            $model->delete();
        }else{
            abort(500);
        }


        return response('The record deleted successfully.', 200);   
    }
}
