<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PublicController extends Controller
{
    /**
     * login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('login');
    }

    /**
     * register
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        return view('register');
    }

    public function doLogin(Request $request) {
        self::validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        $userInfo = Subscriber::where(['email' => $request->email])->first();
        if ($userInfo) {
            if (password_verify($request->password, $userInfo->password)) {
                $user = Subscriber::find($userInfo->email);
                $user->lastlogin = date('Y-m-d H:i:s', time());
                $user->save();
                $request->session()->put('loginUserInfo', $userInfo);
                return Redirect('/');
            } else {
                return Redirect('/login')->with('message', 'Password error.')->withInput();
            }
        } else {
            return Redirect('/login')->with('message', 'Can not found this e-mail account.')->withInput();
        }
    }

    public function autoLogin($email, $password)
    {
        $userInfo = Subscriber::where(['email' => $email])->first();
        dd($userInfo);
    }

    public function doRegister(Request $request)
    {
        self::validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:subscriber',
            'password' => 'required|string|min:6|confirmed',
        ]);


        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->name = $request->name;
        $subscriber->password = password_hash($request->password, PASSWORD_DEFAULT);
        $subscriber->admin = 0;
        $insertRes = $subscriber->save();
        if ($insertRes) {
            self::autoLogin($request->email, $request->password);
        } else {
            return Redirect('/register')->with('message', 'Register fail.')->withInput();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('loginUserInfo');
        return Redirect('/login');
    }
}
