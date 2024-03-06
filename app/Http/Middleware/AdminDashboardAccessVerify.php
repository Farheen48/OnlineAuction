<?php

namespace App\Http\Middleware;

use App\Models\AdminLogin;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardAccessVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $get_token = Session::get('access_token');
        $verify_token = AdminLogin::where([
            ['access_token', '=', $get_token],
            ['time_limit', '>=', Carbon::now()],
            ['status', '=', 'Active']
        ])->exists();
        if ($verify_token === true) {
            return $next($request);
        } else {
            Session::flush();
            return redirect()->route('admin.login');
        }
    }
}
