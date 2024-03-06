<?php

namespace App\Http\Middleware;

use App\Models\AuctionItem;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ActiveItemForBid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->token;
        $serial = $request->serial;
        $bid_item_validate = AuctionItem::where([
            ['serial', '=', $serial],
            ['token', '=', $token],
            ['bidding_staus', '=', 'live'],
            ['time_limit', '>=', Carbon::now()],
        ])
        ->whereNull('status')->exists();
        if($bid_item_validate === true){
            return $next($request);
        }else{
            return redirect()->back()->with('showAlert', true)->with('message', 'Item is offline');
        }
    }
}
