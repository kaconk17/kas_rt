<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = apache_request_headers();
      $user = User::where('api_token',base64_decode($token['token_req']))->first();
        if($user){
            return $next($request);
          }
          return response()->json([
            'message' => 'Not a valid API request.',
          ]);
    }
}
