<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 2018/4/09
     */
    public function index()
    {
        $pagedata['articleList'] = Article::all();
        return view('home', $pagedata);
    }
}
