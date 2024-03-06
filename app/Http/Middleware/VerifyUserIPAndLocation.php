<?php

namespace App\Http\Middleware;

use App\Helpers\helper;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserIPAndLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('access_token')){
            $session_email = Session::get('email');
            $ip = Session::get('ip');
            $longitude = Session::get('long');
            $latitude = Session::get('lat');
            $verifyUser = helper::FilterUser($session_email, $ip, $latitude, $longitude);
            if($verifyUser === "allowed"){
                return $next($request);
            }else{
                User::where('email','=', $session_email)->update([
                    'status' => 'Inactive',
                    'updated_at' => Carbon::now()
                ]);
                Session::flush();
                return redirect()->back()->with('showAlert', true)->with('message', 'You are banned for illegal activities. Please contact with the admin');
            }
        }else{
            return redirect('login');
        }
    }
}
