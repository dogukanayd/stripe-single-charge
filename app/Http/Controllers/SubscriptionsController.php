<?php

namespace App\Http\Controllers;

use App\User;
use Laravel\Cashier\Billable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class SubscriptionsController extends Controller
{
    use Billable;

    public function charge(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => 1999,
                'currency' => 'usd'
            ));

            return 'Charge successful, you get the course!';
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }


    }
}
