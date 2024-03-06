<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LoginRerouteIfExistsAcces
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token = Session::get('access_token');
        $path = Session::get('path');
        if (!empty($access_token)){
            if ($path === 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($path === 'User') {
                return redirect()->route('user.dashboard');
            } elseif ($path === 'Seller') {
                return redirect()->route('seller.dashboard');
            }
        } else {
            return $next($request);
        }
    }
}
