<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_token',
        'auth_user_id',
    ];


    // public static function createSession($user){
    //     Session::create([
    //         'access_token' => auth()->login($user),
    //         'auth_user_id' => $user->id,
    //     ]);

    //     return response()->json([
    //         'access_token' => auth()->login($user),
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 1
    //     ]);
    // }
}
