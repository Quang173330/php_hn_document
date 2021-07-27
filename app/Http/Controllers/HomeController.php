<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with('categories')
            ->where('parent_id', '=', config('uploads.category_root'))
            ->get();

        return view('user.home', compact('categories'));
    }

    public function changeLanguage($locale)
    {
        Session::put('language', $locale);

        return redirect()->back();
    }
}
