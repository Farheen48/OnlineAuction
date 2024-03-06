<?php

namespace App\Http\Controllers\Signup;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator as IDGen;

class UserSignup extends Controller
{
    public function SingupFormUserRegistration(Request $req){
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|email|unique:users,email',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator, 'emailErrors')->withInput();
            }
            $name = $req->name;
            $email = $req->email;
            $path = 'User';
            $gen_sl = IDGen::generate(['table' => 'users', 'field' => 'sl_index', 'length' => 8, 'prefix' => '0']);
            $serial = $path . '-' . $gen_sl;
            $password = Hash::make($req->login_pass);

            $save_user = new User();
            $save_user->serial = $serial;
            $save_user->sl_index = $gen_sl;
            $save_user->name = $name;
            $save_user->email = $email;
            $save_user->password = $password;
            $save_user->path = $path;
            $save_user->save();

            return redirect()->route('login')->with('showAlert', true)->with('message', 'Registered successfully please login now');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $line = $e->getLine();
            return view('pages.errors.exception')->with('error', $error)->with('line', $line);
        }
    }
}
