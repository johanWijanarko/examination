<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            $previous_session = Auth::User()->session_id;
            
            if ($previous_session !== Session::getId()) {
                Auth::logout();
                return redirect('login');
            
            }
        }
        return $next($request);
    }

}