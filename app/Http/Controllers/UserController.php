<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\PegawaiModels;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
// use Spatie\Activitylog\Traits\LogsActivity;


class UserController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:daftar_user-list|daftar_user-create|daftar_user-edit|daftar_user-delete|daftar_user-detail', ['only' => ['index', 'store']]);
        $this->middleware('permission:daftar_user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:daftar_user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:daftar_user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:daftar_user-detail', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cari = $request->cari;
        $title_page = "Management User";
        $data = User::with('hasAuditors')->where('name', 'like', '%' . $cari . '%')
            ->orderBy('name', 'asc')->paginate(10);

        return view('users.index', compact('data', 'title_page'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title_page = "Management User";
        $roles = Role::pluck('name', 'name')->all();
        $data = PegawaiModels::orderBy('pegawai_name', 'asc')->where('pegawai_del_st', 1)->pluck('pegawai_name', 'pegawai_id')->all();
        // dd($roles);
        return view('users.create', compact('roles', 'data', 'title_page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function generateUUID($length)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
    public function store(Request $request)
    {
        $if_exists = User::where('name', $request->name)->count();
        if ($if_exists) {
            Alert::warning('Warning', 'User Sudah di Gunakan');
            return redirect()->route('users.create');
        }
        
            $input = $this->validate($request, [
                'name' => 'required',
                'password' => 'required|same:confirm-password',
                'roles' => 'required',
            ]);
      
            $save_file = [
                'name' => $request->name,
                'password' => $request->password,
                'roles' => $request->roles,
                'user_internal_id' => $request->pegawai,
                'user_foto' => $request->foto,

            ];
        
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filename = time() . '.' . $request->file('file')->extension();
            $filename =$this->generateUUID(6). '.' . $request->file('file')->getClientOriginalName();
            $validatedData = $request->file('file')->storeAs('public/upload', $filename);
            $save_file['user_foto'] = $filename;
        }
        $save_file['password'] = Hash::make($save_file['password']);
        $user = User::create($save_file);
        // dd($user->assignRole($request->input('roles'))); 
        $user->assignRole($request->input('roles'));

        Alert::success('Success', 'User created successfully');
        return redirect()->route('users.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title_page = "Management User";
        $user = User::find($id);
        return view('users.show', compact('user', 'title_page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title_page = "Management User";
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $data = PegawaiModels::orderBy('pegawai_name', 'asc')->pluck('pegawai_name', 'pegawai_id')->all();
        // dd($data2);
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole', 'data', 'title_page'));
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
        if ($request->roles != null || '') {
            $this->validate($request, [
                'name' => 'required',
                'password' => 'same:confirm-password',
                'roles' => 'required'
            ]);

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            $getOld = ($request->old)? $request->old : [];
       
            $checkFile = User::where('id', $id)->pluck('id');
            // dd($checkFile);
            foreach ($checkFile as $key => $file) {
                if(!in_array($file, $getOld)){
                    $getDelete =User::where('id',$file)->first();
                    Storage::delete('public/upload/'.$getDelete->user_foto);
                    $DelFoto = ['user_foto' => ""];
                    User::where('id', $file)->update($DelFoto);
                }
            }  
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //Custom name pattern as per application preference
                $filename = time() . '.' . $request->file('file')->extension();

                //Or - Get the original name of the uploaded file
                $filename =$this->generateUUID(6). '.' . $request->file('file')->getClientOriginalName();

                //Store the file in desired directory and assign the path to the file field in validated data
                $validatedData = $request->file('file')->storeAs('public/upload', $filename);
                $input['user_foto'] = $filename;
            }
            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();

            $user->assignRole($request->input('roles'));
            Alert::success('Success', 'User updated successfully');
            return redirect()->route('users.index');
                // ->with('success', 'User updated successfully');
        } else {
            $this->validate($request, [
                'name' => 'required',
                'password' => 'same:confirm-password'
            ]);

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }
            
            $getOld = ($request->old)? $request->old : [];
       
            $checkFile = User::where('id', $id)->pluck('id');
            // dd($checkFile);
            foreach ($checkFile as $key => $file) {
                if(!in_array($file, $getOld)){
                    $getDelete =User::where('id',$file)->first();
                    Storage::delete('public/upload/'.$getDelete->user_foto);
                    // $getDelete->delete();
                }
            }  
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //Custom name pattern as per application preference
                $filename = time() . '.' . $request->file('file')->extension();

                //Or - Get the original name of the uploaded file
                $filename =$this->generateUUID(6). '.' . $request->file('file')->getClientOriginalName();

                //Store the file in desired directory and assign the path to the file field in validated data
                $validatedData = $request->file('file')->storeAs('public/upload', $filename);
                $input['user_foto'] = $filename;
            }else{
                $input['user_foto'] = '';
            }
            $user = User::find($id);
            $user->update($input);

            Alert::success('Success', 'User updated successfully');
            return redirect()->route('users.index');
        }
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
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
    public function confrimDel($id){
        $getUser = User::find($id);
        return view('users.delete', compact('getUser'));
        
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function chek_user(Request $request){
        $if_exists = User::where('name', $request->name)->count();
        // dd($if_exists);
        $status = false;

        if ($if_exists > 0) { // jika sudah ada, maka true
            $status = true;
        }

        echo json_encode(array('status' => $status));
    }

    public function out_user($id)
    {
        $user = User::find($id);
        // dd($user);
        return view('users.out', compact('user'));
    }
    public function nonaktif($id){
        // dd($id);
        $session = ['session_id' => ""];
        User::where('id', $id)->update($session);
        Alert::success('Success', 'User berhasil dinonaktifkan');
        return redirect()->route('users.index');  
    }
}
