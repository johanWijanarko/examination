<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;

class AutoLogout
{
    
    protected $session;
    protected $timeout = 10000;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        $is_logged_in = $request->path() != 'logout';

        if(!session('last_active')) {
            $this->session->put('last_active', time());
        } elseif(time() - $this->session->get('last_active') > $this->timeout) {
            if(Auth::check()){

                Auth::user()->session_id = '';
                Auth::user()->save();
                
                $this->session->forget('last_active');
                auth()->logout();
                return redirect('login');
            }

            
        }

        $is_logged_in ? $this->session->put('last_active', time()) : $this->session->forget('last_active');
        
        return $next($request);
    }
}