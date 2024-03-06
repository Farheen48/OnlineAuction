<?php

namespace App\Http\Controllers\DashboardController;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Category;
use App\Models\MockIP;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as IMG;
use App\Models\Balence;

class AdminCrontroller extends Controller
{
    public function ViewDashboard(){
        return view('pages.backend.dashboard.admin.dashboard');
    }
    public function SellerList(){
        try{
            $get_data = User::join('money_transacs','users.serial', 'money_transacs.identifier')
            ->where('path', '=', 'Seller')
            ->select('users.*', 'money_transacs.amount', 'money_transacs.status AS payemnt_status')->paginate(4);
            return view('pages.backend.dashboard.admin.seller_list',compact('get_data'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function SellerListStatusUpdate(Request $req){
        try {
            $serial = $req->serial;
            $status = $req->status;
            User::where('serial','=', $serial)->update([
                'status' => $status,
                'updated_at' => Carbon::now()
            ]);
            return redirect()->back()->with('showAlert', true)->with('message', 'Seller status updated');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function CategoryList(){
        $get_category = Category::paginate(10);
        return view('pages.backend.dashboard.admin.category_list',compact('get_category'));
    }

    public function CategoryListInsert(Request $req){
        try{
            $validatedInputData = $req->validate([
                'category' => 'required|unique:categories,category',
                'image' => 'required|mimes:jpg,jpeg,webp,png',
            ]);
            $category = $req->category;
            $image = $req->image;
            $file_name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('assets/images/category/' . $file_name_gen);

            $image = IMG::make($image)->resize(200, 200);

            $watermarkPath = public_path('assets/images/favicon.png');
            if (file_exists($watermarkPath)) {
                $watermark = IMG::make($watermarkPath);
                $watermark->opacity(50);
                $image->insert($watermark, 'bottom-right', 10, 10);
            }

            $image->save($path);

            $final_product_img = '/public/assets/images/category/' . $file_name_gen;

            $save_category = new Category();
            $save_category->category = $category;
            $save_category->image = $final_product_img;
            $save_category->save();

            return redirect()->back()->with('showAlert', true)->with('message', 'Category saved');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function CategoryListStaus(Request $req){
        try{
            $category_name = $req->category_name;
            $status = $req->status;
            Category::where('category','=', $category_name)->update([
                'status' => $status,
                'updated_at' => Carbon::now()
            ]);
            return redirect()->back()->with('showAlert', true)->with('message', 'Category status updated');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function BidReqSeller(){
        $pending_bid_item = AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
        ->where('auction_items.bidding_staus', '=', 'not-approved')
        ->select(
            'auction_items.serial',
            'seller_product_lists.name',
            'seller_product_lists.starting_price',
            'seller_product_lists.image',
            'auction_items.category',
        )
        ->get();
        return view('pages.backend.dashboard.admin.pending_auction',compact('pending_bid_item'));
    }

    public function ViewBidReq(Request $req){
        $validator = Validator::make($req->all(), [
            'serial' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'emailErrors')->withInput();
        }
        $serial = $req->serial;
        $pending_bid_item = AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
        ->where('auction_items.serial', '=', $serial)
        ->select(
            'auction_items.serial',
            'seller_product_lists.name',
            'seller_product_lists.starting_price',
            'seller_product_lists.image',
            'auction_items.category',
        )
        ->first();
        return view('pages.backend.dashboard.admin.pending_auction_view', compact('pending_bid_item'));
    }

    public function SetItemPermitedForBidding(Request $req){
        $validator = Validator::make($req->all(), [
            'serial' => 'required',
            'day' => 'required|numeric',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $serial = $req->serial;
        $day = $req->day;
        $month = $req->month;
        $year = $req->year;

        $carbonDate = Carbon::now();
        $carbonDate->day = $day;
        $carbonDate->month = $month;
        $carbonDate->year = $year;

        $carbonDate->hour = date('H');
        $carbonDate->minute = date('i');
        $carbonDate->second = date('s');

        $formattedDate = $carbonDate->format('Y-m-d H:i:s');
        AuctionItem::where('serial', $serial)
            ->update([
                'time_limit' => $formattedDate,
                'bidding_staus' => 'live',
                'updated_at' => Carbon::now()
            ]);

        return redirect()->back()->with('showAlert', true)->with('message', 'Bidding status updated and activated');
    }

    public function UpdateMockLocation(Request $req){
        $moc_ip = $req->moc_ip;
        MockIP::where('index','=','status')->update([
            'value' => $moc_ip,
            'updated_at' => Carbon::now()
        ]);
        return redirect()->back()->with('showAlert', true)->with('message', 'MockIP status updated');
    }

    public function MakeBidClosed(Request $req){
        try {
            $serial = $req->serial;
            $data = AuctionItem::join('seller_product_lists', 'auction_items.serial', 'seller_product_lists.serial')
                ->where([
                ['auction_items.serial', '=', $serial],
                ['auction_items.bidding_staus', '=', 'live'],
                ['auction_items.time_limit', '<', Carbon::now()]
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
            if($upate_auction_item){
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
                return redirect()->back()->with('showAlert', true)->with('message', 'Bidding status updated and closed');
            }else{
                return redirect()->back()->with('showAlert', true)->with('message', 'Bidding status could not be update');
            }

        } catch (Exception $e) {
            DB::rollBack();
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function UpdateBiding(Request $req){
        $status = $req->status;
        $serial = $req->serial;
        AuctionItem::where('serial' ,'=',
            $serial)->update([
            'bidding_staus' => $status,
            'updated_at' => Carbon::now()
            ]);
        return redirect()->back()->with('showAlert', true)->with('message', 'Auction item status updated');
    }

}
