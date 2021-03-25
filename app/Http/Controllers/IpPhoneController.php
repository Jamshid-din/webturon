<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\DepartList;
use App\SubDepartList;
use App\IpList;


class IpPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $depart_list    = DepartList::where('status', 1)->orderBy('sort', 'ASC')->get();
        $sub_depart_list = SubDepartList::where('status', 1)->orderBy('sort', 'ASC')->get();

        return view('components.ip_phones',compact('depart_list','sub_depart_list'));
    }


    public function fetchData(Request $request){

        $sub_dep_id = $request->input('id');
        switch ($sub_dep_id) {
            case 0:
            case 1:
    
                $models = DB::table('ip_lists AS a')
                    ->join('depart_lists AS b', 'a.depart_id', 'b.id')
                    ->join('sub_depart_lists AS c', 'a.sub_depart_id', 'c.id')
                ->select('a.id','a.fio','a.ip','a.descr','b.title_uz AS dep_title_uz', 'b.title_ru AS dep_title_ru', 
                'c.title_uz AS sub_title_uz','c.title_ru AS sub_title_ru')
                ->where('a.status', 1)
                ->orderBy('a.id', 'ASC')
                ->get();
    
                break;

            default:

                $models = DB::table('ip_lists AS a')
                    ->join('depart_lists AS b', 'a.depart_id', 'b.id')
                    ->join('sub_depart_lists AS c', 'a.sub_depart_id', 'c.id')
                ->select('a.id','a.fio','a.ip','a.descr','b.title_uz AS dep_title_uz', 'b.title_ru AS dep_title_ru', 
                'c.title_uz AS sub_title_uz','c.title_ru AS sub_title_ru')
                ->where('a.sub_depart_id', $sub_dep_id)
                ->where('a.status', 1)
                ->orderBy('a.id', 'ASC')
                ->get();

                break;
        }
        
        return response()->json(array('success' => true, 'Sub_Dep_Id' => $sub_dep_id, 'msg' => $models));
    }

    public function adminIpIndex(Request $request){


        $current_user_role = Auth::user()->roles->role_code;
        if($current_user_role != "super_admin" && $current_user_role != "it_admin" && $current_user_role != "strategy"){
            abort(404);
        } 
        
        $parentDep = DepartList::orderBy('sort', 'ASC')->get();
        $childDep = SubDepartList::where('depart_id', $request->input(['depart_id']))->orderBy('sort', 'ASC')->get();

        if($request->input()) {

            $depart_id      = $request->input(['depart_id']);
            $sub_depart_id  = $request->input(['sub_depart_id']);
            $fio            = $request->input(['fio']);
            $descr          = $request->input(['descr']);
            $ip             = $request->input(['ip']);
            $status         = $request->input(['status']);

            $currentDep     = DepartList::find($depart_id);
            $currentSubDep  = SubDepartList::where($sub_depart_id);
            $search         = IpList::orderBy('depart_id', 'ASC');

            if($depart_id)      $search->where('depart_id', $depart_id);

            if($sub_depart_id)  $search->where('sub_depart_id', $sub_depart_id);

            if($fio)            $search->where('fio', 'like', '%'. $fio .'%');

            if($descr)          $search->where('descr', 'like', '%'.$descr.'%');

            if($ip)             $search->where('ip', $ip);

            if($status != null) $search->where('status', $status);

            $models = $search->paginate(10);

            $models->appends ( array (
                'depart_id'     => $depart_id,
                'sub_depart_id' => $sub_depart_id,
                'fio'           => $fio,
                'descr'         => $descr,
                'ip'            => $ip,
                'status'        => $status
            ));
            
            return view('admin.ip.index',
            compact('models','parentDep','childDep','currentDep','currentSubDep','depart_id','sub_depart_id','fio','descr','ip','status'));
        }
        $models = IpList::orderBy('depart_id', 'ASC')->paginate(10); 

        return view('admin.ip.index',compact('models','parentDep','childDep'));
    }

    public function adminIpStore(Request $request)
    {
        $this->validate($request, [
            'depart_id'     => 'required',
            'sub_depart_id' => 'required',
            'fio'           => 'required',
            'descr'         => 'required',
            'ip'            => 'required',
            'status'        => 'required',
        ]);

        $new                = new IpList();
        $new->bank_user_id  = Auth::id();
        $new->depart_id     = $request->input('depart_id');
        $new->sub_depart_id = $request->input('sub_depart_id');
        $new->fio           = $request->input('fio');
        $new->descr         = $request->input('descr');
        $new->ip            = $request->input('ip');
        $new->status        = $request->input('status');
        $new->save();

        return back()->with('success', 'Successfully stored');        
    }

    public function adminIpUpdate(Request $request)
    {
        $this->validate($request, [
            'depart_id'     => 'required',
            'sub_depart_id' => 'required',
            'fio'           => 'required',
            'descr'         => 'required',
            'ip'            => 'required',
            'status'        => 'required',
        ]);

        $id = $request->input('id');
        $model = IpList::findOrFail($id);

        $update = $model->update([
            'bank_user_id'  => Auth::id(),
            'depart_id'     => $request->input('depart_id'),
            'sub_depart_id' => $request->input('sub_depart_id'),
            'fio'           => $request->input('fio'),
            'descr'         => $request->input('descr'),
            'ip'            => $request->input('ip'),
            'status'        => $request->input('status'),
        ]);

        return back()->with('success', 'Successfully updated');
    }

    public function adminGetSubDep($id)
    {
        $sub_menu = SubDepartList::where('depart_id', $id)->orderBy('sort', 'ASC')->get();

        return response()->json(['sub_menu' => $sub_menu]);
    }

    public function adminIpDelete($id)
    {
        $model = IpList::findOrFail($id);
        $model->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function adminIpOld($id)
    {
        $model          = IpList::findOrFail($id);
        $dep            = DepartList::find($model->depart_id);
        $sub_dep        = SubDepartList::find($model->sub_depart_id);
        $dep_list       = DepartList::orderBy('sort', 'ASC')->get();
        $sub_dep_list   = SubDepartList::where('depart_id',$model->depart_id)->orderBy('sort', 'ASC')->get();

        return response()->json(['oldIp' => $model, 'dep' => $dep, 'sub_dep' => $sub_dep, 'dep_list' => $dep_list, 'sub_dep_list' => $sub_dep_list]);
    }
}
