<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ArticleController extends Controller
{
    protected $category;

    public function __construct()
    {
        $this->category = ['Technology','Entertainment','Digital','Spotrs','Health','International','Financial','Military'];
    }

    public function add()
    {
        if (!session('loginUserInfo')) {
            return redirect('/login')->with('message', 'Please login first.');
        }
        $pagedata['categoryList'] = $this->category;
        return view('add', $pagedata);
    }

    public function doAdd(Request $request)
    {
        if (!session('loginUserInfo')) {
            return redirect('/login')->with('message', 'Please login first.');
        }

        self::validate($request, [
            'title' => 'required|string|max:255',
            'link' => 'required|string|url',
            'category' => 'required|string',
            'body' => 'required|string',
        ]);

        $articleMdl = new Article();
        $articleMdl->subscriberID = session('loginUserInfo')->email;
        $articleMdl->title = $request->title;
        $articleMdl->link = $request->link;
        $articleMdl->category = $request->category;
        $articleMdl->body = $request->body;
        $res = $articleMdl->save();
        if ($res) {
            return Redirect('/');
        } else {
            return Redirect('/article/add')->with('message', 'Add article fail.')->withInput();
        }
    }

    public function edit($id)
    {
        $pagedata['articleData'] = Article::findOrFail($id);
        $pagedata['categoryList'] = $this->category;
        return view('edit', $pagedata);
    }

    public function doEdit(Request $request)
    {
        if (!session('loginUserInfo')) {
            return redirect('/login')->with('message', 'Please login first.');
        }

        self::validate($request, [
            'articleID' => 'required',
            'title' => 'required|string|max:255',
            'link' => 'required|string|url',
            'category' => 'required|string',
            'body' => 'required|string',
        ]);
        $article = Article::find($request->articleID);
        $article->title = $request->title;
        $article->link = $request->link;
        $article->category = $request->category;
        $article->body = $request->body;
        $res = $article->save();
        if ($res) {
            return Redirect("/detail/$request->articleID");
        } else {
            return Redirect("/article/edit/$request->articleID")->with('message', 'Edit fail,plase try again.')->withInput();
        }
    }

    public function doDelete($id)
    {
        $res = Article::destroy($id);
        if ($res) {
            return Redirect('/');
        } else {
            return Redirect("/detail/$id")->with('message', 'Delete fail,plase try again.');
        }
    }
}
