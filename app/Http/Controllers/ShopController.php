<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (request()->category){
            $products = Product::with('categories')->whereHas('categories', function ($query){
               $query->where('slug', request()->category);
            })->paginate(9);
            $categories = Category::all();
            $categoryName = $categories->where('slug', request()->category)->first()->name;
        }else {
            $products = Product::inRandomOrder()->take(12)->paginate(9);
            $categories = Category::all();
            $categoryName = 'Featured';
        }

        if (request()->sort === 'low_high'){
            $products = $products->sortBy('price');
        }elseif (request()->sort === 'high_low'){
            $products = $products->sortByDesc('price');
        }

        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();

        return view('product')->with([
            'product' => $product,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }
}
