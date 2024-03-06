<?php

namespace App\Http\Controllers\Signup;

use App\Http\Controllers\Controller;
use App\Models\MoneyTransac;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator as IDGen;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class SellerSingup extends Controller
{
    protected $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    }
    public function SingupFormSellerRegistration(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|email|unique:users,email',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator, 'emailErrors')->withInput();
            }
            $name = $req->name;
            $email = $req->email;
            $path = 'Seller';
            $gen_sl = IDGen::generate(['table' => 'users', 'field' => 'sl_index', 'length' => 8, 'prefix' => '0']);
            $serial = $path . '-' . $gen_sl;
            $password = Hash::make($req->login_pass);
            $payment_token = Str::random(10);
            $payment_description = 'Seller_reg_fee';
            $price = config('appConfig.seller_reg_fee');

            $save_user = new User();
            $save_user->serial = $serial;
            $save_user->sl_index = $gen_sl;
            $save_user->name = $name;
            $save_user->email = $email;
            $save_user->password = $password;
            $save_user->path = $path;
            $save_user->status = 'Pending';
            $save_user->save();

            $save_balance = new MoneyTransac();
            $save_balance->identifier = $serial;
            $save_balance->token = $payment_token;
            $save_balance->description = $payment_description;
            $save_balance->amount = $price;
            $save_balance->save();

            return redirect()->route('seller.registration_payment',[
                'payment_token' => $payment_token,
                'identifier' => $serial
            ])->with('showAlert', true)->with('message', 'Wrong transaction credentials');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function RegistrationFee(Request $req){
        try {
            $payment_token = $req->payment_token;
            $identifier = $req->identifier;

            if (!empty($payment_token) && !empty($identifier)) {
                return view('pages.payment.seller_reg_payment');
            } else {
                return redirect()->route('welcome')->with('showAlert', true)->with('message', 'Wrong transaction credentials');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function PayRegistrationFee(Request $req){
        try {
            $price = $req->price;
            $payment_token = $req->payment_token;
            $identifier = $req->identifier;
            $card_number = $req->card_number;
            $year = $req->year;
            $month = $req->month;
            $cvc = $req->cvc;
            $converted = strval($price * 100);
            $description = 'User -' . $identifier . ' paid for seller registration fee.TrxID:' . $payment_token . '. UIU Auction system';
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
                MoneyTransac::where([
                    'identifier' => $identifier,
                    'token' => $payment_token
                ])->update([
                    'status' => $charge->status,
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->route('login')->with('showAlert', true)->with('message', 'Payment successful.Please wait for approval');
            }else{
                return redirect()->back()->with('showAlert', true)->with('message', 'Something went wrong in stripe transaction.Please try again later');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }
}
