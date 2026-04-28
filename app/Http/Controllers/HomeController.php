<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)->take(6)->get();
        $categories = Category::all();
        
        return view('home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
        ]);
    }
}
