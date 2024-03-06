<?php

namespace App\Http\Controllers\DashboardController;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Category;
use App\Models\SellerProductList;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as IMG;
use Haruncpi\LaravelIdGenerator\IdGenerator as IDGen;

class SellerController extends Controller
{
    public function SellerDashbaord(){
        return view('pages.backend.dashboard.seller.dashboard');
    }

    public function RegisterProductList(){
        try {
            $serial = Session::get('serial');
            $get_list = SellerProductList::where('seller_serial', $serial)->paginate(10);
            return view('pages.backend.dashboard.seller.reg_product',compact('get_list'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function SubmitRegisterProductList(Request $req){
        try{
            $validatedInputData = $req->validate([
                'product_name' => 'required',
                'starting_price' => 'required|numeric',
                'description' => 'required|max:100',
                'image' => 'required|mimes:jpg,jpeg,webp,png',
            ]);
            $product_name = $req->product_name;
            $starting_price = $req->starting_price;
            $description = $req->description;
            $image = $req->image;
            $serial = IDGen::generate(['table' => 'seller_product_lists', 'field' => 'serial', 'length' => 8, 'prefix' => '0']);

            $file_name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('assets/images/seller_product/' . $file_name_gen);

            $image = IMG::make($image)->resize(150, 200);

            $watermarkPath = public_path('assets/images/favicon.png');
            if (file_exists($watermarkPath)) {
                $watermark = IMG::make($watermarkPath);
                $watermark->opacity(50);
                $image->insert($watermark, 'bottom-right', 10, 10);
            }

            $image->save($path);

            $final_product_img = '/public/assets/images/seller_product/' . $file_name_gen;

            $save_data = new SellerProductList();
            $save_data->serial = $serial;
            $save_data->seller_serial = Session::get('serial');
            $save_data->image = $final_product_img;
            $save_data->name = $product_name;
            $save_data->short_des = $description;
            $save_data->starting_price = $starting_price;
            $save_data->save();

            return redirect()->back()->with('showAlert', true)->with('message', 'Product saved');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function ViewRegisteredProduct(){
        try{
            $serial = Session::get('serial');
            $get_list = SellerProductList::leftjoin('auction_items', 'seller_product_lists.serial' ,'auction_items.serial')
            ->where('seller_serial', $serial)->select('seller_product_lists.*', 'auction_items.bidding_staus', 'auction_items.price_collected',
            'auction_items.time_limit')->paginate(10);
            return view('pages.backend.dashboard.seller.reg_product_list',compact('get_list'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }
    public function ViewRequestForAuctionForm(Request $req){
        try{
            $serial = $req->serial;
            $product_details = SellerProductList::where('serial', $serial)->first();
            $fetch_categories = Category::all();
            return view('pages.backend.dashboard.seller.reg_product_req_for_auction', compact(
                'product_details',
                'fetch_categories'
                )
            );
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function PostRequestForAuctionForm(Request $req){
        try{
            $req->validate([
                'starts_at' => 'required',
                'category' => 'required',
            ]);
            $serial = $req->serial;
            $starts_at = $req->starts_at;
            $category = $req->category;
            $temp_image = '/public/assets/images/logo/logo.png';
            $itme_token = Str::random(60);
            $store_auction_item = new AuctionItem();
            $store_auction_item->serial = $serial;
            $store_auction_item->category = $category;
            $store_auction_item->token = $itme_token;
            $store_auction_item->save();

            $item = SellerProductList::find($serial);
            if($item){
                $item->starting_price = $starts_at;
                $item->save();
            }
            $category = Category::firstOrNew([
                'category' => $category,
                'image' => $temp_image,
                'created_at' => Carbon::now()
            ]);

            return redirect()->back()->with('showAlert', true)->with('message', 'Registered successfully. Please wait for admin approval');

        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }
}
