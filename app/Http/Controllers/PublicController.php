<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 2018/4/11
     */
    public function login()
    {
        return view('login');
    }

    /**
     * register
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 2018/4/11
     */
    public function register()
    {
        return view('register');
    }

    public function doLogin(Request $request)
    {
        self::validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:subscriber',
            'password' => 'required|string|min:6|confirmed',
        ]);
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
            $result = [
                'status' => 1,
                'msg' => 'Register success.',
                'data' => []
            ];
        } else {
            $result = [
                'status' => 1,
                'msg' => 'Register fail, please try again.',
                'data' => []
            ];
        }
        return response::json($request);
    }
}
