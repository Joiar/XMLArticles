<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    /**
     * doLogin
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doLogin(Request $request)
    {
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
                $sessionData = DB::table('subscriber')->select('email', 'name', 'lastlogin')->where(['email' => $request->email])->first();
                $request->session()->put('loginUserInfo', $sessionData);
                return Redirect('/');
            } else {
                return Redirect('/login')->with('message', 'Password error.')->withInput();
            }
        } else {
            return Redirect('/login')->with('message', 'Can not found this e-mail account.')->withInput();
        }
    }

    /**
     * autoLogin
     * @param $email
     * @param $password
     * @return bool
     */
    public function autoLogin($email, $password)
    {
        $userInfo = Subscriber::where(['email' => $email])->first();
        if ($userInfo) {
            if (password_verify($password, $userInfo->password)) {
                $user = Subscriber::find($userInfo->email);
                $user->lastlogin = date('Y-m-d H:i:s', time());
                $user->save();
                $sessionData = DB::table('subscriber')->select('email', 'name', 'lastlogin')->where(['email' => $email])->first();
                session(['loginUserInfo' => $sessionData]);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * doRegister
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
            $loginRes = self::autoLogin($request->email, $request->password);
            if ($loginRes) {
                return Redirect('/');
            } else {
                return Redirect('/login')->with('message', 'Network error,please try again.')->withInput();
            }
        } else {
            return Redirect('/register')->with('message', 'Register fail.')->withInput();
        }
    }

    /**
     * logout
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->forget('loginUserInfo');
        return Redirect('/login');
    }
}
