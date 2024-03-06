<?php

namespace App\Http\Controllers\LoginController;

use App\Http\Controllers\Controller;
use App\Models\AdminLogin;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function ViewDashboard(){
        return view('pages.backend.dashboard.admin.dashboard');
    }

    public function VerifyAdmin(Request $req){
        try{
            $validatedInputData = Validator::make($req->all(), [
                'email' => 'required|email',
            ]);
            $email = $req->email;
            $useragent = $req->useragent;
            $verify_email = AdminLogin::where([
                ['email',$email],
                ['status','Active']
                ])->exists();
            if($verify_email === true){
                $access_token = Str::random(60);
                $time_limit = Carbon::now()->addDays(10);
                $otp = rand(1001,9999);
                AdminLogin::where([
                    ['email', $email],
                    ['status', 'Active']
                ])->update([
                    'otp' => $otp,
                    'device' => $useragent,
                    'access_token' => $access_token,
                    'time_limit' => $time_limit,
                ]);
                Mail::to($email)->send(new OtpMail($otp));
                return redirect()->route('verify.OTP',['email'=>$email, 'useragent'=> $useragent]);
            }else{
                return redirect()->back()->with('showAlert', true)->with('message', 'Your credentials did not match');
            }
        }catch(Exception $e){
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }

    public function VerifyAdminOTP(){
        return view('pages.frontend.loginSingup.helper_page.admin_otp');
    }

    public function ValidateOTP(Request $req){
        try{
            $validator = Validator::make($req->all(), [
                'otp' => 'required|numeric|digits:4|not_in:0000,00000',
            ]);
            $email = $req->email;
            $device = $req->useragent;
            $otp = $req->otp;
            $verify_otp = AdminLogin::where([
                ['email', $email],
                ['device', $device],
                ['otp', $otp]
            ])->exists();
            if($verify_otp === true){
               $get_details =  AdminLogin::where([
                    ['email', $email],
                    ['device', $device],
                    ['otp', $otp],
                    ['status', 'Active']
                ])->get();
                foreach($get_details as $ad){
                    $name = $ad->name;
                    $email = $ad->email;
                    $access_token = $ad->access_token;
                    $path = $ad->path;
                }
                AdminLogin::where([
                    ['email', $email],
                    ['device', $device],
                    ['otp', $otp]
                ])->update([
                    'otp' => 0,
                    'updated_at' => Carbon::now()
                ]);
                Session::put([
                    'name' => $name,
                    'email' => $email,
                    'access_token' => $access_token,
                    'path' => $path,
                ]);
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->back()->with('showAlert', true)->with('message', 'Your credentials did not match');
            }
        }catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }
}
