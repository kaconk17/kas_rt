<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        $level = Session::get('level');
        
        if (Session::get('login')== true){
            
            foreach($roles as $role) {
               
                if($level == $role){

                    return $next($request);
                }
                
            }
            return redirect()->route('home');
          
        }else {
            
            return redirect()->route('login');
        }
    }
}
