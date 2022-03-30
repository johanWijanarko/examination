<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Traits\HasRoles;
// use Spatie\Activitylog\Models\Activity;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
// use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    use HasFactory, Notifiable, HasRoles;

    protected static $logAttributes = ['name', 'email'];
    protected static $recordEvents = ['deleted', 'updated', 'created'];
    protected static $logName = 'user';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function getDescriptionForEvent(string $eventName): string
    // {
    //     return "Anda telah melakukan {$eventName} data";
    // }

    public function index(Request $request)
    {
        $roles = Role::when($request->cari, function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->cari . '%');
                })->orderBy('id', 'DESC')->paginate(5);
        // dd($roles);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getMenu1 = DB::table('menu')->where('status',1)->where('master_menu', 0)->orderBy('no_urut','asc')->get();
        $permission =new Permission;
       
        return view('roles.create', compact('permission', 'getMenu1'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->permission);
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getMenu = DB::table('menu')->where('status',1)->where('master_menu', 0)->orderBy('no_urut','asc')->get();
        $permission =new Permission;
        $role = Role::find($id);
        // $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        // dd($role);
        return view('roles.edit', compact('role', 'permission', 'rolePermissions', 'getMenu'));
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
         $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        // 
        $role->syncPermissions($request->input('permission'));
        // activity()->log("{.$eventName.}");
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }

    public function confrimDel($id)
    {
        $deleteConfrim = DB::table("roles")->where('id', $id)->first();
        // dd($dataproyek);
        return view(
            'roles/delete',
            compact('deleteConfrim')
        );
    }
    public function delete($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
