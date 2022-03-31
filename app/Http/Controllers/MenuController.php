<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        //  $this->middleware('permission:menu-list|menu-create|menu-edit|menu-delete|menu-detail', ['only' => ['index','store']]);
        //  $this->middleware('permission:menu-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:menu-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
        //  $this->middleware('permission:menu-detail', ['only' => ['show']]);
    }

    public function index(Request $request)
    {
        $cari= $request->cari;
        $title_page = "Management Menu";
        $paginate = 10;
        $menus= MenuModel::with('children')->where('status', 1)->where('master_menu', 0)->when($request->cari, function($q) use ($request){
            $q->where('nama_menu', 'like', '%'.$request->cari.'%');
        })->withCount('children')
        ->paginate($paginate);
        // dd($menus);
         return view('menu.index', compact('menus', 'title_page'))
         ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title_page = "Management Menu";
        $menu = DB::table('menu')->where('master_menu', '0')->get();
        return view('menu.create', compact('menu', 'title_page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'permission' => 'required'
        ]);
        $save_menu = [
            'nama_menu' =>$request->nama_menu,
            'master_menu' =>0,
            'url' =>$request->url,
            'icon' =>$request->icon,
            'permission' =>$request->permission,
            'no_urut' =>$request->nourut,
            'status' => 1

        ];
        // dd($save_menu);
        $permission = [
            'list',
            'create',
            'edit',
            'delete',
            'detail'
        ];

        // dd($save_menu);
        $affected = DB::table('menu')
        ->insert($save_menu);

        $role = Role::where('name', 'Admin')->first();
        foreach($permission as $permiss){
            $nmpermission = $request->permission.'-'.$permiss;
            Permission::create(['name' => $nmpermission]);
            $role->givePermissionTo($nmpermission);
        }


        Alert::success('Success','Data berhasil di Simpan');
        return redirect('user/menu');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $title_page = "Edit Menu";
        $menus = DB::table('menu')
        ->where('status', 1)
        ->where('id', $id)
        ->get();
       return view('menu.edit', compact('menus', 'title_page'));
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
        $request->validate([
            'nama_menu' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'permission' => 'required'
        ]);

        $save_menu = [
            'nama_menu' =>$request->nama_menu,
            'url' =>$request->url,
            'icon' =>$request->icon,
            'permission' =>$request->permission,
            'no_urut' =>$request->nourut

        ];
        $permission = [
            'list',
            'create',
            'edit',
            'delete',
            'detail'
        ];


        $affected = DB::table('menu')
        ->where('id', $id);
        $data = $affected->first();
        $affected->update($save_menu);
        // dd($data->permission);
        if($data->permission == null){

            $role = Role::where('name', 'Admin')->first();

            foreach($permission as $permiss){
                $nmpermission = $request->permission.'-'.$permiss;
                Permission::create(['name' => $nmpermission]);
                $role->givePermissionTo($nmpermission);
            }
        }


        Alert::success('Success','Data berhasil di Update');
        return redirect('user/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $delmenu = DB::table('menu')->where('id', $id)
        ->update(['status'=> 0]);


        Alert::success('Success','Data berhasil di Dihapus');
        return redirect('user/menu');
    }
    public function delete($id)
    {
        // dd($id);
        $menus = DB::table('menu')
        ->where('status', 1)
        ->where('id', $id)
        ->first();
        return view('menu.delete', compact('menus'));
    }

    // Submenu
    public function confrimdelete($id, $parent)
    {
        // dd($id);
        $menus = DB::table('menu')
        ->where('status', 1)
        ->where('id', $id)
        ->first();
        return view('menu.deletesub', compact('menus', 'parent'));
    }

    public function deleteSub($id, $parent)
    {
        // dd($parent);
        $delmenu = DB::table('menu')->where('id', $id)
        ->update(['status'=> 0]);
        // $delmenu = DB::table('menu')->where('id', $id)
        // ->delete();


        Alert::success('Success','Data berhasil di Dihapus');
        return redirect('user/menu/subMenu/'.$parent);
    }
    public function submenu(Request $request, $id)
    {
        $cari= $request->cari;
        $title_page = "Management Sub Menu";
        $paginate = 10;
        $subMenu= MenuModel::where('status', 1)->where('master_menu', $id)->when($request->cari, function($q) use ($request){
            $q->where('nama_menu', 'like', '%'.$request->cari.'%');
        })->withCount('children')
        ->paginate($paginate);
        // dd($menus);
         return view('menu.submenu', compact('subMenu', 'title_page', 'id'))
         ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function tbh_sub(Request $request, $id){
        return view('menu.create_sub', compact('id'));
    }
    public function save_sub(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'nama_menu' => 'required',
            'url' => 'required',
            'permission' => 'required'
        ]);
        $save_menu = [
            'nama_menu' =>$request->nama_menu,
            'master_menu' =>$id,
            'url' =>$request->url,
            'permission' =>$request->permission,
            'no_urut' =>$request->nourut,
            'status' => 1
        ];
        // dd($save_menu);
        $permission = [
            'list',
            'create',
            'edit',
            'delete',
            'detail'
        ];

        // dd($save_menu);
        $affected = DB::table('menu')
        ->insert($save_menu);

        $role = Role::where('name', 'Admin')->first();
        foreach($permission as $permiss){
            $nmpermission = $request->permission.'-'.$permiss;
            Permission::create(['name' => $nmpermission]);
            $role->givePermissionTo($nmpermission);
        }



        Alert::success('Success','Data berhasil di Simpan');
        return redirect('user/menu/subMenu/'.$id);
    }
    public function edit_sub(Request $request, $id, $parent)
    {
        $title_page = "Edit Menu";
        $sub_menu = DB::table('menu')
        ->where('id', $id)
        ->first();
       return view('menu.edit_sub', compact('sub_menu', 'title_page', 'parent'));
    }
     public function update_sub(Request $request, $id)
    {
         $request->validate([
            'nama_menu' => 'required',
            'url' => 'required',
            'permission' => 'required'
        ]);
        $save_menu = [
            'nama_menu' =>$request->nama_menu,
            'url' =>$request->url,
            'no_urut' =>$request->nourut

        ];
        // dd($save_menu);

        $affected = DB::table('menu')
        ->where('id', $id)->update($save_menu);


        Alert::success('Success','Data berhasil di Update');
        return redirect('user/menu/subMenu/'.$request->parent);
    }
}
