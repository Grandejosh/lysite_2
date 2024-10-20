<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Session;  //para Recaptcha

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'g-recaptcha-response' => function ($attribute, $value, $fail) {                   //para Recaptcha
                $secretKey = config('services.recaptcha.secret');
                $response = $value;
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url ="https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIP";
                $response= \file_get_contents($url);
                $response= json_decode($response);
                if(!$response->success){
                    Session::flash('g-recaptcha-response', 'Porfavor marca la recaptcha');
                    Session::flash('alert-class', 'alert-danger');
                    $fail($attribute.' google reCaptcha falló');
                }
            },                //para Recaptcha
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'email' =>['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => function ($attribute, $value, $fail) {
                $secretKey = config('services.recaptcha.secret');
                $response = $value;
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url ="https://www.google.com/recaptcha/api/siteverify?secretKey&response=$response&remoteip=$userIP";
                $response= \file_get_contents($url);
                $response= json_decode($response);
                if(!$response->success){
                    Session::flash('g-recaptcha-response', 'Porfavor marca la recaptcha');
                    Session::flash('alert-class', 'alert-danger');
                    $fail($attribute.'google reCaptcha failed');
                }
            },
        ]);
    }
}
