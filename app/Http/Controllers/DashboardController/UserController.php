<?php

namespace App\Http\Controllers\DashboardController;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Balence;
use App\Models\MoneyTransac;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Stripe\StripeClient;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $stripe;
    public function __construct(){
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    }
    public function UserDashbaord(){
        return view('pages.backend.dashboard.user.dashboard');
    }

    public function AddBalance(){
        return view('pages.backend.dashboard.user.add_balance');
    }

    public function RechargeBalance(Request $req){
        try {
            $price = $req->price;
            $card_number = $req->card_number;
            $year = $req->year;
            $month = $req->month;
            $cvc = $req->cvc;
            $converted = strval($price * 100);
            $trx = Str::random(5);
            $description = 'User -'.Session::get('name').' has added balances. TrxID:'.$trx.'. UIU Auction system';
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $card_number,
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'cvc' => $cvc
                ]
            ]);
            $charge = $this->stripe->charges->create([
                'amount' => $converted,
                'currency' => 'usd',
                'source' => $token,
                'description' => $description
            ]);
            if ($charge->status === 'succeeded') {
                $payment_token = Str::random(10);
                $payment_description = 'Balance';

                $save_balance = new MoneyTransac();
                $save_balance->identifier = Session::get('serial');
                $save_balance->token = $payment_token;
                $save_balance->description = $payment_description;
                $save_balance->amount = $price;
                $save_balance->status = $charge->status;
                $save_balance->save();

                $validate_balance = Balence::where('serial', Session::get('serial'))->exists();
                if($validate_balance === true){
                    Balence::where('serial', Session::get('serial'))->increment('balance', $price, [
                        'updated_at' => Carbon::now()
                    ]);
                }else{
                    $add_balence = new Balence();
                    $add_balence->serial = Session::get('serial');
                    $add_balence->balance = $price;
                    $add_balence->save();
                }
                return redirect()->route('user.dashboard')->with('showAlert', true)->with('message', 'Balance added');
            }else{
                return redirect()->back()->with('showAlert', true)->with('message', 'Something went wrong in stripe transaction.Please try again later');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function SubmitABidForItem(Request $req){
        try{
            $validatedInputData = $req->validate([
                'bid_price' => 'required',
            ]);
            $bid_price = $req->bid_price;
            $token = $req->token;
            $serial = $req->serial;
            $bid_item_validate = AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
            ->where([
                ['auction_items.serial', '=', $serial],
                ['auction_items.token', '=', $token],
                ['auction_items.bidding_staus', '=', 'live'],
            ])
            ->whereNull('auction_items.status')->exists();
            if($bid_item_validate === true){
                $get_user_balence = Balence::where('serial','=',Session::get('serial'))->value('balance');
                $get_user_bidding_expences = Balence::where('serial','=',Session::get('serial'))->value('bitting_expence');
                $bidable_amount = $get_user_balence - $get_user_bidding_expences;
                if($bidable_amount>= $bid_price&& $get_user_balence> $get_user_bidding_expences){
                    $auction_detail = AuctionItem::where([
                        ['serial', '=', $serial],
                        ['token', '=', $token],
                        ['bidding_staus', '=', 'live'],
                    ])->first();
                    $current_bid = $auction_detail->current_price;
                    if($bid_price > $current_bid){
                        $total_bidders = json_decode($auction_detail->total_bid, true);
                        $currentTime = Carbon::now();
                        $formattedTime = $currentTime->format('YmdHis');
                        $randomString = Str::random(10);
                        $uniqueString = $formattedTime . $randomString;
                        $bidder_collection = collect();
                        if (empty($total_bidders)) {
                            $bidder_collection->push([
                                'id' => $uniqueString,
                                'user_id' => Session::get('serial'),
                                'name' => Session::get('name'),
                                'price' => $bid_price,
                            ]);
                        } else {
                            foreach ($total_bidders as $key => $tb) {
                                $bidder_collection->push([
                                    'id' => $tb['id'],
                                    'user_id' => $tb['user_id'],
                                    'name' => $tb['name'],
                                    'price' => $tb['price'],
                                ]);
                            }
                            $bidder_collection->push([
                                'id' => $uniqueString,
                                'user_id' => Session::get('serial'),
                                'name' => Session::get('name'),
                                'price' => $bid_price,
                            ]);
                        }
                        AuctionItem::where([
                          ['serial', '=', $serial],
                          ['token', '=', $token],
                          ['bidding_staus', '=', 'live'],
                        ])->update([
                            'total_bid' => json_encode($bidder_collection),
                            'current_price' => $bid_price,
                            'updated_at' => Carbon::now()
                        ]);
                        Balence::where('serial', '=', Session::get('serial'))->increment('bitting_expence', $bid_price);
                        $bid_live_preview = collect()->push([
                            'bidder_collection' => $bidder_collection,
                            'current_price' => $bid_price,
                            'total_bidder' => $bidder_collection->count(),
                        ]);
                        $key = $token.$serial;
                        Cache::put($key, $bid_live_preview, Carbon::now()->addHours(1));
                        return redirect()->back()->with('showAlert', true)->with('message', 'Your bid is successfully placed');
                    }else{
                        return redirect()->back()->with('showAlert', true)->with('message', 'Please increase  your bid price');
                    }
                }else{
                    return redirect()->route('user.dashboard')->with('showAlert', true)->with('message', 'Sorry insufficient balance.Please add more');
                }
            }else{
                return redirect()->route('welcome')->with('showAlert', true)->with('message', 'Item is offline');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }
}
