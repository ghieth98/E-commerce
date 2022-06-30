<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\OrderProduct;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('checkout')->with([
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $contents = Cart::content()->map(function ($item){
           return $item->model->slug.', '.$item->qty;
        })->values()->toJson();
        try {
        $charge = Stripe::charges()->create([
            'amount' => $this->getNumbers()->get('newTotal') / 100,
            'currency' => 'CAD',
            'source' => $request->stripeToken,
            'description' => 'Order',
            'receipt_email' => $request->email,
            'metadata' => [
//                //change to Order ID after we start using DB
                'contents' => $contents,
                'quantity' => Cart::instance('default')->count(),
                'discount' => collect(session()->get('coupon'))->toJson(),
            ],
        ]);
            //TODO insert into order table
            $order = Order::create([
                'billing_email'=>$request->email,
                'billing_name'=>$request->name,
                'billing_address'=>$request->address,
                'billing_city'=>$request->city,
                'billing_province'=>$request->province,
                'billing_postcode'=>$request->postcode,
                'billing_phone'=>$request->phone,
                'billing_name_on_card'=>$request->name_on_card,
                'billing_discount'=> $this->getNumbers()->get('discount'),
                'billing_discount_code'=> $this->getNumbers()->get('code'),
                'billing_subtotal'=> $this->getNumbers()->get('newSubtotal'),
                'billing_tax'=> $this->getNumbers()->get('newTax'),
                'billing_total'=> $this->getNumbers()->get('newTotal'),
                'error' => null,
            ]);
            //TODO insert into pivot table order_product
            foreach (Cart::content() as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->model->id,
                    'quantity' => $item->qty,
                ]);
            }
            // SUCCESSFUL
            Cart::instance('default')->destroy();
            session()->forget('coupon');
//            Mail::send(new OrderPlaced());
            // return back()->with('success_message', 'Thank you! Your payment has been successfully accepted!');
            return redirect()->route('confirmation.index')
                ->with('success_message',
                    'Thank you! Your payment has been successfully accepted!');
            //TODO  Check the documentation for the exception
        } catch (CardErrorException $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getNumbers()
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $code = session()->get('coupon')['name'] ?? null;
        $newSubtotal = (Cart::subtotal() - $discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);
        return collect([
            'tax' => $tax,
            'discount' => $discount,
            'code' => $code,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal,

        ]);
    }
}
