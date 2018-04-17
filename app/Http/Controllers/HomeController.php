<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Subscriber;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    protected $category;

    public function __construct()
    {
        $this->category = ['Technology','Entertainment','Digital','Spotrs','Health','International','Financial','Military'];
    }

    /**
     * index
     * @param null $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($category = null)
    {
        $pagedata['currentTab'] = '/';
        if ($category) {
            $pagedata['articleList'] = Article::where('category', $category)->paginate(10);
            $pagedata['currentTab'] = $category;
        } else {
            $pagedata['articleList'] = Article::paginate(10);
        }
        $pagedata['categoryList'] = $this->category;
        return view('home', $pagedata);
    }

    /**
     * detail
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 2018/4/14
     */
    public function detail($id)
    {
        $pagedata['articleDetail'] = Article::findOrFail($id);
        $pagedata['articleDetail']->author = Subscriber::where('email', $pagedata['articleDetail']->subscriberID)->first()->name;
        $pagedata['isSelf'] = false;
        if (session('loginUserInfo') && $pagedata['articleDetail']->subscriberID == session('loginUserInfo')->email) {
            $pagedata['isSelf'] = true;
        }
        return view('detail', $pagedata);
    }

    /**
     * search
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $pagedata['keywords'] = $keywords;
        $pagedata['articleList'] = Article::where('title', 'like', "%$keywords%")->orWhere('body', 'like', "%$keywords%")->paginate(10);
        return view('search', $pagedata);
    }
}
