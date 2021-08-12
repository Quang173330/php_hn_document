<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use Session;
use App\Repositories\Category\CategoryRepositoryInterface;

class HomeController extends Controller
{
    protected $cateRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryRepositoryInterface $cateRepo)
    {
        $this->cateRepo = $cateRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories =  $this->cateRepo->getCategoriesRoot();

        return view('user.home', compact('categories'));
    }

    public function changeLanguage($locale)
    {
        Session::put('language', $locale);

        return redirect()->back();
    }
}
