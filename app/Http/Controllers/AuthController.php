<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    const BASE_URL = 'http://lapi-auth.test.laravel-sail.site:8080/api/';

    public static function login($email, $password)
    {
        $response = Http::post(AuthController::BASE_URL . 'account', [
            "email" => $email,
            "password" => $password,
        ]);
        dd($response->json());
    }

    public static function isTokenValid($token)
    {

        $response = Http::get(AuthController::BASE_URL . 'validate/' . (explode(' ', $token)[1]));
        $token = $response->object();
        return $token->expired == false && $token->expire_in > 60;
    }

    public static function refreshToken($token)
    {
        $response = Http::withToken(explode(' ', $token)[1])->get(AuthController::BASE_URL . 'access_token/refresh');
        echo $response->status();
        echo ($response->body());
    }
}
