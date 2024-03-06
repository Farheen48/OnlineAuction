<?php

namespace App\Helpers;

use App\Models\User;

class Helper
{
    public static function FilterUser($email, $ip, $latitude, $longitude){
        $verifyEmailAsUser = User::where([
            ['email', '=', $email],
            ['path', '=', 'User']
        ])->exists();

        if ($verifyEmailAsUser === true) {
            $ipAssociatedWithSeller = User::join('user_seller_i_p_locations', 'users.serial', 'user_seller_i_p_locations.serial')
                ->where('user_seller_i_p_locations.ip', '=', $ip)
                ->where('users.path', '=', 'Seller')
                ->exists();
            if ($ipAssociatedWithSeller === true) {
                $res = 'not-allowed';
            }else{
                $validate_location = User::join('user_seller_i_p_locations', 'users.serial', 'user_seller_i_p_locations.serial')
                ->where('user_seller_i_p_locations.long', '=', $longitude)
                ->where('user_seller_i_p_locations.lat', '=', $latitude)
                ->where('user_seller_i_p_locations.ip', '=', $ip)
                ->where('users.status', '=', 'Active')
                ->where('users.path', '!=', 'Seller')
                ->exists();
                if ($validate_location) {
                    $res = 'allowed';
                }else{
                    $res = 'not-allowed';
                }
            }
        }else{
            $res = 'not-allowed';
        }
        return $res;
    }
}
