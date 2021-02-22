<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\User;
use App\Role;

class UserController extends Controller
{

    public function index(User $model)
    {
        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin"){
            abort(404);
        } 

        $users = User::orderBy('id', 'ASC')->paginate(15);
        $roles = Role::orderBy('id', 'ASC')->get();

        return view('admin.users.user.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'store_role'    => 'required',
            'store_name'    => 'required|max:255',
            'email'         => 'email|string|unique:users|required|max:255',
            'password'      => 'required|string|confirmed|min:8',
            'store_status'  => 'required'
  
        ]);

        $new            = new User();
        $new->name      = $request->input('store_name');
        $new->email     = $request->input('email');
        $new->role      = $request->input('store_role');
        $new->password  = Hash::make($request->input('password'));
        $new->status    = $request->input('store_status');
        $new->save();
        
        return back()->with('success', 'Successfully stored');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'role'      => 'required',
            'name'      => 'required',
            'status'    => 'required'
        ]);

        

        if($request->input('password')){
            $this->validate($request,[
                'password'  => 'confirmed|min:8',
            ]);
        }

        $id = $request->input('id');

        $update = User::find($id);
        $password = $update->password;

        if($request->input('password')) $password = Hash::make($request->input('password'));

        $update->update([
            'name'      => $request->input('name'),
            'role'      => $request->input('role'),
            'password'  => $password,
            'status'    => $request->input('status')
        ]);

        
        return back()->with('success', 'Successfully updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = User::findOrFail($id);
        $role = Role::find($model->role);
        return response()->json(['oldModel' => $model, 'role' => $role]);
    }

    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $model->delete();
        
        return response()->json(['success' => 'Successfully deleted!!!' ]);
    }
}
