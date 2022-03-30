<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function ubah_password(Request $request, $id){
        $user = User::find($id);
        // dd($user);
        return view('menu.ubah_password',compact('user'));
    }
    function generateUUID($length)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
    public function update_password(Request $request, $id)
    {
            $this->validate($request, [
                'name' => 'required',
                'password' => 'same:confirm-password',
            ]);

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);

            } else {
                $input = Arr::except($input, array('password'));
            }
            
            $getOld = ($request->old)? $request->old : [];
       
            $checkFile = User::where('id', $id)->pluck('id');

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
            if($request->password){
                $session = ['session_id' => ""];
                User::where('id', $id)->update($session);
            }
            Alert::success('Success', 'User updated successfully');
            return redirect()->route('dashboard');        
        
    }

   
  
}
