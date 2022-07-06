<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
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
     * @return Application|Factory|View
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();
        $inStock = getInStock($product->quantity);

        return view('product')->with([
            'product' => $product,
            'inStock' => $inStock,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function search(Request $request)
    {
        DB::statement("SET sql_mode = '' ");
        $request->validate([
            'query' => 'required|min:3'
        ]);

        $query = $request->input('query');
        $products = Product::search($query)->paginate(10);
        return view('search-results')->with('products', $products);
    }
}
