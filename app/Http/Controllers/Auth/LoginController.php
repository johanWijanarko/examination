<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('otentifikasi.login');
    }
    public function username(){
        return 'name';
    }
    protected function authenticated()
    {
        // Update last_session after logged-in
        User::find(Auth::id())->update(['session_id'=>Session::getId()]);
    }
     public function login(Request $request)
    {
        // $TimeLog =Auth::user()->time_login;
        // $dt = Carbon::now()->isoFormat('H:m:s');
        // // dd($dt->isoFormat('H:m:s'));
        // dd(((strtotime($dt)-strtotime($TimeLog))/60));
        $checkUser = DB::table('users')->where('name', $request->name)->first();
        if($checkUser){
            if($checkUser->session_id){
                $sessionDel = ['session_id' => ''];
                $updateUser = DB::table('users')->where('name', $request->name)->update($sessionDel);
                Alert::warning('Warning', 'Silahkan login sekali lagi untuk menghapus history login');
                return redirect('login');
            } else{
                
            }
            request()->validate([
            'name' => 'required',
            'password' => 'required',
            ]);

            $credentials = $request->only('name', 'password');
            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                if(Auth::user()->session_id == ''){
                    Auth::user()->session_id = Session::getId();
                    Auth::user()->save();
                    
                }elseif(Auth::user()->session_id != ''){
                    if (Auth::user()->session_id !== Session::getId()) {
                        Auth::logout();
                        return redirect('login');
                    }
                }

                
                $keterangan = 'User '. $user->name. ' Telah melakukan Login Aplikasi';
                $this->save_log('login',$keterangan,$user );
                return redirect('/dashboard');
            }
        }
        
        return redirect('login')->withErrors('Oppes! Silahkan Cek User dan Password');
        
    }
    public function logout(Request $request)
    {
        Auth::user()->session_id = NULL;
    
        Auth::user()->save();
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
