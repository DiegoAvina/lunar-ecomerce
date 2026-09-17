<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lunar\Facades\CartSession;
use Lunar\Models\Address;
use Lunar\Models\Customer;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $customer = Customer::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->firstOrFail();

        $cart = CartSession::current();

        if (! $cart || $cart->lines->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $addresses = $customer->addresses()->get();

        $countries = \Lunar\Models\Country::orderBy('name')->get();

        return view('checkout.index', [
            'cart' => $cart,
            'customer' => $customer,
            'addresses' => $addresses,
            'countries' => $countries,
        ]);
    }

    public function storeAddress(Request $request)
    {
        $user = Auth::user();

        $customer = Customer::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->firstOrFail();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'tax_identifier' => ['nullable', 'string', 'max:255'],

            'line_one' => ['required', 'string', 'max:255'],
            'line_two' => ['nullable', 'string', 'max:255'],
            'line_three' => ['nullable', 'string', 'max:255'],

            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],

            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:30'],

            'delivery_instructions' => ['nullable', 'string', 'max:1000'],

            'shipping_default' => ['nullable', 'boolean'],
            'billing_default' => ['nullable', 'boolean'],
        ]);

        $validated['customer_id'] = $customer->id;
        $validated['country_id'] = 143;

        $validated['shipping_default'] =
            $request->boolean('shipping_default');

        $validated['billing_default'] =
            $request->boolean('billing_default');

        $address = Address::create($validated);

        return redirect()
            ->route('checkout.index')
            ->with('success', 'Dirección guardada correctamente.');
    }
}