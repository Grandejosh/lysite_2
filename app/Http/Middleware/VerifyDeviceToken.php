<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Cookie;

class VerifyDeviceToken
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next) //descomentar el codigo para activar las Sesiones unicas
    {
        $user = $this->auth->user();

        $deviceToken = $_COOKIE['device_token'];

            if ($user && $user->device_token && $user->device_token !== $deviceToken) {
                $response = redirect()->route('logout')->with('error', 'Se ha iniciado sesión desde otro dispositivo.');

                // Eliminar la cookie 'device_token'
                $response->withCookie(cookie()->forget('device_token'));

                return $response;
            }


        return $next($request);
    }
}
