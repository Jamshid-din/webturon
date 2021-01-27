<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\AnonymousMessage;
use App\User;
use App\News;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $messages = AnonymousMessage::orderBy('created_at', 'DESC')->paginate(10);
        $users = User::orderBy('id', 'ASC')->get();

        return view('dashboard',compact('messages', 'users'));
    }

    public function update(Request $request)
    {

        // dd($request->all());
        # code...
        $this->validate($request, [
            'title' => 'required',
            'text'  => 'required',
        ]);

        $id = $request->input('id');
        $model = AnonymousMessage::findOrFail($id);

        $model->update([
            'title'  => $request->input('title'),
            'text'   => $request->input('text'),
        ]);

        return back()->with('success', 'Successfully stored');
    }

    public function show($id)
    {
        # code...
        $model = AnonymousMessage::findOrFail($id);

        return response()->json(['model' => $model]);
    }

    public function destroy($id)
    {
        $model = AnonymousMessage::findOrFail($id);
        $model->delete();

        return response('The record deleted successfully.', 200);   
    }

}
