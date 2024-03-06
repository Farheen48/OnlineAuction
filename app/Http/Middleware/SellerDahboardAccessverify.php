<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SellerDahboardAccessverify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $get_serial = Session::get('serial');
        $email = Session::get('email');
        $get_token = Session::get('access_token');
        if(!empty($get_serial) && !empty($get_token)){
            $verify_user = User::where([
                ['serial', '=', $get_serial],
                ['email', '=', $email],
                ['access_token', '=', $get_token],
                ['time_limit', '>=', Carbon::now()],
                ['status', '=', 'Active']
            ])->exists();
            if($verify_user === true){
                return $next($request);
            }else{
                Session::flush();
                return redirect()->route('login');
            }
        }else{
            Session::flush();
            return redirect()->route('login');
        }
    }
}
