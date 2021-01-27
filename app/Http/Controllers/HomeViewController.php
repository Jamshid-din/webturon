<?php

namespace App\Http\Controllers;

use App\AnonymousMessage;
use App\News;

use Illuminate\Http\Request;

class HomeViewController extends Controller
{
    //
    public function index(){

        $models = News::orderBy('created_at', 'DESC')->paginate(3);
        return view('components.home_components', compact('models'));
    }
    public function indexSlider(){

        $models = News::orderBy('created_at', 'DESC')->paginate(3);
        return view('slider.home_slider', compact('models'));
    }
    

    public function store(Request $request)
    {
        # code...
        $this->validate($request, [
            'title' => 'required|max:150',
            'text'  => 'required|max:400',
        ]);

        $new = new AnonymousMessage();
        $new->title = $request->input('title');
        $new->text = $request->input('text');
        $new->save();

        return back()->with('success', 'Successfully stored');
    }

}
