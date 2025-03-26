<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected UserService $userService,
        protected BrandService $brandService,
        protected CategoryService $categoryService,
        protected ProductService $productService
    ) {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $view = [
            'users_count' => $this->userService->countUsers(),
            'brands_count' => $this->brandService->countBrands(),
            'categories_count' => $this->categoryService->countCategories(),
            'products_count' => $this->productService->countProducts(),
        ];
        return view('home', $view);
    }
}
