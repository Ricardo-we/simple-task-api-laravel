<?php
namespace App\Utils;

class UserUtils {
    public function __construct(){}

    public static function itemIsOfUser(int $item_user_id){
        $user = auth("sanctum")->user();
        return $user->id == $item_user_id;
    }
}