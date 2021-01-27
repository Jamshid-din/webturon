<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Role;
use App\User;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin"){
            abort(404);
        } 

        $models = Role::paginate(10);
        return view('admin.users.roles.index', compact('models'));
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
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'role_code' => 'required',
            'status'    => 'required'
        ]);
        $new = new Role();
        $new->title_uz  = $request->input('title_uz');
        $new->title_ru  = $request->input('title_ru');
        $new->role_code = $request->input('role_code');
        $new->status    = $request->input('status');
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
        $model = Role::findOrFail($id);
        return response()->json(['model' => $model]);
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
        $id = $request->input('id');

        $this->validate($request,[
            'title_uz'  => 'required',
            'title_ru'  => 'required',
            'status'    => 'required'        
        ]);

        $update = Role::find($id);

        $update->update([
            'title_uz'  => $request->input('title_uz'),
            'title_ru'  => $request->input('title_ru'),
            'status'    => $request->input('status')
        ]);

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
        $role = Role::findOrFail($id);
        $users = User::where('role', $role->id)->get();

        if($users->count()){
            return response()->json(['error' => 'You can`t remove this role cause of existing users in this role!']);
        }else{
            $role->delete();
            return response('The record deleted successfully', 200);
        }
    }
}
