<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mightAlsoLike = Product::mightAlsoLike()->get();

        return view('cart')->with('mightAlsoLike', $mightAlsoLike);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(Product $product)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($product){
            return $cartItem->id === $product->id;
        });

        if ($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success_message', 'Item is already in cart');
        }

        Cart::add($product->id, $product->name, 1, $product->price)
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item added to your cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Cart::remove($id);

        return back()->with('success_message', 'Item has been removed!');
    }

    public function saveForLater($id)
    {
        $item = Cart::get($id);

        Cart::remove($id);

        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id){
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success_message', 'Item is already saved for later');
        }

        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item saved for later');
    }
}
