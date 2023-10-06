<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Stripe;

class StripePaymentController extends Controller
{
    public function stripe($id)
    {
        $order = Order::find($id);
        session()->put('order_id', $order->id);
        return view('stripe', compact('order'));
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $order = Order::find(session()->get('order_id'));
        
        /*
        Stripe\Stripe::setApiKey(config('app.stripe_secret'));
        Stripe\Charge::create ([
                //"name" => "Laravel Lumen",
                //"email" => "iCfJX@example.com",
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment via stripe",
                //"address" => ["city" => 'San Jose', "country" => "US", "line1" => "1234 Main st", "line2" => "", "postal_code" => "95131", "state" => "CA"]
        ]);
        */
        $stripe = new Stripe\StripeClient(config('app.stripe_secret'));

            $stripe->paymentIntents->create([
            'description' => 'Product Payment',
            'shipping' => [
                'name' => $order->name,
                'address' => [ 
                    'line1' => $order->address.' '.$order->address2,
                    'postal_code' => $order->zip_code,
                    'city' => $order->city,
                    'state' => $order->ostate? $order->ostate->name : '',
                    'country' => $order->country,
                ],
            ],
            'amount' => $order->amount * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            ]);

        $order->payment = $order->amount;
        $order->save();
        session()->forget('order_id');
        session()->flash('success', 'Payment successful!');
          
        return redirect()->route('checkoutSuccess');
    }
}
