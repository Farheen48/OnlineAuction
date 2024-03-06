<?php

namespace App\Http\Controllers\GeneralController;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Balence;
use App\Models\MockIP;
use App\Models\User;
use App\Models\UserSellerIPLocation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Faker\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    public function __construct(){
        $this->AutoUpdateBidToClosed();
    }
    public function Index(){
        return view('pages.frontend.welcome');
    }

    public function Login(){
        return view('pages.frontend.loginSingup.login');
    }

    public function SignUpFormView(Request $req){
        $path = $req->path;
        if($path === 'seller'){
            return view('pages.frontend.loginSingup.signup_seller');
        }elseif ($path === 'client'){
            return view('pages.frontend.loginSingup.signup_user');
        }else{
            return redirect()->back()->with('showAlert', true)->with('message', 'Please select a route first');
        }
    }

    public function AdminLogin(){
        return view('pages.frontend.loginSingup.admin_login');
    }

    public function LoginVerify(Request $req){
        try {
            $validatedInputData = $req->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $mock_ip_status=MockIP::where('index','=','status')->value('value');
            $email = $req->email;
            $lat = $req->lat;
            $long = $req->long;
            $password = $req->password;
            if (empty($lat) && empty($long)) {
                return redirect()->back()->with('showAlert', true)->with('message', 'Please allow the location access');
            } else {
                $verify_user = User::where('email', $email)->exists();
                if($verify_user === true){
                    $user = User::where('email', $email)->first();
                    $serial = $user->serial;
                    $name = $user->name;
                    $savedPassword = $user->password;
                    $status = $user->status;
                    $path = $user->path;
                    if($mock_ip_status === 'on'){
                        $generate_fake_ip = Factory::create();
                        $fake_ip = $generate_fake_ip->ipv4;
                    }else{
                        $fake_ip = $req->ip();
                    }
                    $access_token = Str::random(60);
                    $time_limit = Carbon::now()->addDays(10);
                    if (Hash::check($password, $savedPassword)){
                        if($path === 'Seller'){
                            if($status === 'Active'){
                               User::where([
                                ['serial', $serial],
                                ['email',$email],
                                ['status','Active']
                                ])->update([
                                    'access_token' => $access_token,
                                    'time_limit' => $time_limit,
                                    'updated_at' => Carbon::now()
                                ]);
                               $save_location =  new UserSellerIPLocation();
                               $save_location->serial = $serial;
                               $save_location->long = $long;
                               $save_location->lat = $lat;
                               $save_location->ip = $fake_ip;
                               $save_location->save();
                                Session::put([
                                    'serial' => $serial,
                                    'name' => $name,
                                    'email' => $email,
                                    'email' => $email,
                                    'access_token' => $access_token,
                                    'path' => $path,
                                    'ip' => $fake_ip,
                                ]);
                                return redirect()->route('seller.dashboard');
                            }else{
                                return redirect()->back()->with('showAlert', true)->with('message', 'Please wait for admin approval and then try to login');
                            }
                        }else{
                            User::where([
                                ['serial', $serial],
                                ['email', $email],
                                ['status', 'Active']
                            ])->update([
                                'access_token' => $access_token,
                                'time_limit' => $time_limit,
                                'updated_at' => Carbon::now()
                            ]);
                            $save_location =  new UserSellerIPLocation();
                            $save_location->serial = $serial;
                            $save_location->long = $long;
                            $save_location->lat = $lat;
                            $save_location->ip = $fake_ip;
                            $save_location->save();
                            Session::put([
                                'serial' => $serial,
                                'name' => $name,
                                'email' => $email,
                                'access_token' => $access_token,
                                'path' => $path,
                                'ip' => $fake_ip,
                                'long' => $long,
                                'lat' => $lat,
                            ]);
                            return redirect()->route('user.dashboard');
                        }
                    }else{
                        return redirect()->back()->with('showAlert', true)->with('message', 'Your credentials did not match');
                    }
                }else{
                    return redirect()->back()->with('showAlert', true)->with('message', 'Sorry We did not find your record. Please signup first');
                }
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function LogOut(){
        try{
            Session::flush();
            return redirect()->route('login');
        }catch(Exception $e){
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function RunningBidlist(){
        $bid_item = AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
        ->where([
            ['auction_items.bidding_staus', '=', 'live'],
            ['auction_items.time_limit', '>=', Carbon::now()]
            ])
        ->select(
            'auction_items.serial',
            'auction_items.token',
            'seller_product_lists.name',
            'seller_product_lists.starting_price',
            'seller_product_lists.image',
            'auction_items.category',
            'auction_items.time_limit'
        )
        ->orderBy('auction_items.updated_at', 'desc')
        ->get();
        return view('pages.frontend.bidding_list',compact('bid_item'));
    }

    public function BiddingitemDetails(Request $req){
        $token = $req->token;
        $serial = $req->serial;
        $bid_item = AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
        ->where([
            ['auction_items.serial', '=', $serial],
            ['auction_items.token', '=', $token],
            ['auction_items.bidding_staus', '=', 'live']
            ])
        ->select(
            'auction_items.serial',
            'auction_items.token',
            'auction_items.total_bid',
            'seller_product_lists.name',
            'seller_product_lists.short_des',
            'seller_product_lists.starting_price',
            'auction_items.current_price',
            'seller_product_lists.image',
            'auction_items.category',
            'auction_items.time_limit'
        )
        ->first();
        return view('pages.frontend.bidding_view',compact('bid_item'));
    }

    public function AuxData(Request $req){
        try{
            $token = $req->token;
            $serial = $req->serial;
            $key = $token . $serial;
            if(Cache::has($key) === true){
                $msg = 'data-fetched';
                $decoded_data = json_decode(Cache::get($key),true);
                $current_price = $decoded_data[0]['current_price'];
                $total_bidder = $decoded_data[0]['total_bidder'];
                $bidder_list = $decoded_data[0]['bidder_collection'];
                $data = [
                    'current_price' => $current_price,
                    'total_bidder' => $total_bidder,
                    'live_bidder' => view('pages.frontend.helper_pages.live_bidder',compact('bidder_list'))->render()
                ];
            }else{
                $verify_product = AuctionItem::where([
                    ['serial', '=', $serial],
                    ['token', '=', $token],
                    ['bidding_staus', '=', 'live'],
                    ['time_limit', '>=', Carbon::now()],
                ])
                ->whereNull('status')->exists();
                $key = $token . $serial;
                $auction_detail = AuctionItem::where([
                    ['serial', '=', $serial],
                    ['token', '=', $token],
                    ['bidding_staus', '=', 'live'],
                ])->first();
                $total_bidders = json_decode($auction_detail->total_bid, true);
                if (!empty($total_bidders)&& $verify_product=== true) {
                    $bidder_list = collect();
                    $bid_price = $auction_detail->current_price;
                    foreach ($total_bidders as $key => $tb) {
                        $bidder_list->push([
                            'id' => $tb['id'],
                            'user_id' => $tb['user_id'],
                            'name' => $tb['name'],
                            'price' => $tb['price'],
                        ]);
                    }
                    $total_bidder = $bidder_list->count();
                    $bid_live_preview = collect()->push([
                        'bidder_collection' => $bidder_list,
                        'current_price' => $bid_price,
                        'total_bidder' => $bidder_list->count(),
                    ]);
                    Cache::put($key, $bid_live_preview, Carbon::now()->addHours(1));
                    $msg = 'data-fetched';
                    $data = [
                        'current_price' => $bid_price,
                        'total_bidder' => $total_bidder,
                        'live_bidder' => view('pages.frontend.helper_pages.live_bidder', compact('bidder_list'))->render()
                    ];
                }else{
                    $msg = 'no-data';
                    $data = [];
                }
            }
            return response()->json([
                'status' => true,
                'error' => 'no',
                'msg' => $msg,
                'data' => $data
            ],200);
        }catch(Exception $e){
            $error = $e->getMessage();
            $line = $e->getLine();
            return response()->json([
                'status' => false,
                'error' => 'unprocessable',
                'msg' => $error.' at line :'.$line,
            ],422);
        }
    }

    private function AutoUpdateBidToClosed(){
        try{
            $running_auction_validate = AuctionItem::where([
                ['bidding_staus', '=', 'live'],
                ['time_limit', '<', Carbon::now()],
                ['current_price', '>', 0]
            ])->whereNotNull('current_price')->exists();

            if($running_auction_validate === true){
                $serial = AuctionItem::where([
                    ['bidding_staus', '=', 'live'],
                    ['time_limit', '<=', Carbon::now()],
                    ['current_price', '>', 0]
                ])->whereNotNull('current_price')->value('serial');
                $data = AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
                ->where([
                    ['auction_items.serial', '=', $serial],
                    ['auction_items.bidding_staus', '=', 'live'],
                    ['time_limit', '<=', Carbon::now()],
                ])->select('auction_items.*', 'seller_product_lists.seller_serial')->first();
                $json_decode_total_bid = json_decode($data->total_bid, true);
                $collection = collect($json_decode_total_bid);
                $maxItem = $collection->max('price');
                $itemWithMaxPrice = $collection->where('price', $maxItem)->first();
                $maxPrice = $itemWithMaxPrice['price'];
                $name = $itemWithMaxPrice['name'];
                $id = $itemWithMaxPrice['id'];
                $user_id = $itemWithMaxPrice['user_id'];

                $upate_auction_item = AuctionItem::where([
                    ['serial', '=', $serial],
                    ['bidding_staus', '=', 'live'],
                    ['time_limit', '<', Carbon::now()]
                ])->update([
                    'bidding_staus' => 'closed',
                    'status' => 'sold',
                    'price_collected' => $maxPrice,
                    'bidder' => $user_id,
                ]);

                if ($upate_auction_item) {
                    DB::beginTransaction();

                    Balence::where('serial', '=', $user_id)->decrement('balance', $maxPrice);

                    $validate_seller = Balence::where('serial', '=', $data->seller_serial)->exists();

                    if ($validate_seller) {
                        Balence::where('serial', '=', $data->seller_serial)->increment('balance', $maxPrice);
                    } else {
                        Balence::insert([
                            'serial' => $data->seller_serial,
                            'balance' => $maxPrice,
                            'created_at' => now(),
                        ]);
                    }

                    DB::commit();
                    $msg = 'Bid updated';
                }else{
                    $msg = 'Problem found while bid update';
                }

            }else{
                $msg = 'No Bid found';
            }

            return response()->json([
                'status' => true,
                'error' => 'no',
                'msg' => $msg,
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            $error = $e->getMessage();
            $line = $e->getLine();
            return response()->json([
                'status' => false,
                'error' => 'unprocessable',
                'msg' => $error . ' at line :' . $line,
            ], 422);
        }
    }
}
