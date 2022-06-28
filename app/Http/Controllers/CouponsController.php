<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon){
            return redirect()->route('checkout.index')
                ->withErrors('Invalid coupon code, Please try again!');
        }

        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $coupon->discount(Cart::subtotal()),
        ]);
        return redirect()->route('checkout.index')->with('success message', 'Coupon has been applied');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        session()->forget('coupon');

        return redirect()->route('checkout.index')->with('success message', 'Coupon has been removed');
    }
}
