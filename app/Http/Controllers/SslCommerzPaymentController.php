<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Cart;
use App\Library\SslCommerzNotification;

class SslCommerzPaymentController extends Controller
{
    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->customer_name;
        $post_data['cus_email'] = $request->customer_email;
        $post_data['cus_add1'] = $request->customer_address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->customer_phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function checkout(Request $request)
    {
        // Check if user is authenticated as customer
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed with checkout.');
        }

        $customer = Auth::guard('customer')->user();

        // Get cart items
        $cartItems = Cart::getCartItems($customer->id);
        $cartTotal = Cart::getCartTotal($customer->id);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate request
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
        ]);

        // Generate unique transaction ID
        $tran_id = 'TXN_' . time() . '_' . $customer->id;

        // Prepare order data
        $products = $cartItems->map(function ($item) {
            return [
                'book_id' => $item->book_id,
                'book_name' => $item->book->book_name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->quantity * $item->price
            ];
        })->toArray();

        // Generate a secure authentication token for post-payment session restoration
        $auth_token = hash('sha256', $customer->id . $tran_id . time() . config('app.key'));

        // Create order record
        $order = Order::create([
            'transaction_id' => $tran_id,
            'customer_id' => $customer->id,
            'total_amount' => $cartTotal,
            'currency' => 'BDT',
            'status' => 'pending',
            'products' => $products,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'auth_token' => $auth_token, // Store the authentication token
        ]);

        // Prepare SSLCOMMERZ data
        $post_data = [
            'store_id' => config('sslcommerz.apiCredentials.store_id'),
            'store_passwd' => config('sslcommerz.apiCredentials.store_password'),
            'total_amount' => $cartTotal,
            'currency' => 'BDT',
            'tran_id' => $tran_id,
            'success_url' => url('/payment/success?auth_token=' . $auth_token),
            'fail_url' => url('/payment/fail?auth_token=' . $auth_token),
            'cancel_url' => url('/payment/cancel?auth_token=' . $auth_token),
            'ipn_url' => url('/payment/ipn'),

            # CUSTOMER INFORMATION
            'cus_name' => $validated['customer_name'],
            'cus_email' => $validated['customer_email'],
            'cus_add1' => $validated['customer_address'],
            'cus_add2' => '',
            'cus_city' => '',
            'cus_state' => '',
            'cus_postcode' => '',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $validated['customer_phone'],
            'cus_fax' => '',

            # SHIPMENT INFORMATION
            'ship_name' => $validated['customer_name'],
            'ship_add1' => $validated['customer_address'],
            'ship_add2' => '',
            'ship_city' => '',
            'ship_state' => '',
            'ship_postcode' => '',
            'ship_country' => 'Bangladesh',

            'shipping_method' => 'NO',
            'product_name' => 'Books',
            'product_category' => 'Books',
            'product_profile' => 'physical-goods',

            # OPTIONAL PARAMETERS
            'value_a' => $customer->id,
            'value_b' => 'book_order',
            'value_c' => $auth_token,
            'value_d' => '',
        ];

        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'sandbox');

        if (!is_array($payment_options)) {
            // Parse the response
            $response = json_decode($payment_options, true);

            if (isset($response['status']) && $response['status'] == 'SUCCESS') {
                // Redirect to payment gateway
                return redirect($response['GatewayPageURL']);
            } else {
                return redirect()->route('cart.index')->with('error', 'Payment initiation failed. Please try again.');
            }
        }

        return redirect()->route('cart.index')->with('error', 'Payment gateway error. Please try again.');
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $auth_token = $request->input('auth_token');

        $sslc = new SslCommerzNotification();

        // Check order status in order table against the transaction id
        $order_details = Order::where('transaction_id', $tran_id)->first();

        if (!$order_details) {
            return redirect()->route('cart.index')->with('error', 'Invalid transaction.');
        }

        // If we have an auth_token in URL, verify it matches the order
        if ($auth_token && $order_details->auth_token !== $auth_token) {
            return redirect()->route('cart.index')->with('error', 'Invalid authentication token.');
        }

        // Get the customer for this order
        $customer = \App\Models\Customer::find($order_details->customer_id);
        if (!$customer) {
            return redirect()->route('cart.index')->with('error', 'Customer not found.');
        }

        // Always re-authenticate the customer to restore session after payment gateway redirect
        if (!Auth::guard('customer')->check() || Auth::guard('customer')->id() !== $customer->id) {
            Auth::guard('customer')->login($customer, true); // 'true' enables "remember me"
            $request->session()->regenerate();
        }

        if ($order_details->status == 'pending') {
            $validation = $this->validateTransaction($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                // Start database transaction to ensure consistency
                DB::beginTransaction();

                try {
                    // Update order status to paid
                    Order::where('transaction_id', $tran_id)->update([
                        'status' => 'paid',
                        'payment_method' => $request->input('card_type'),
                        'bank_tran_id' => $request->input('bank_tran_id'),
                        'card_type' => $request->input('card_type'),
                        'store_amount' => $request->input('store_amount')
                    ]);

                    // Clear the customer's cart after successful payment - with explicit logging
                    $cartItemsCount = Cart::where('customer_id', $order_details->customer_id)->count();
                    $deletedRows = Cart::where('customer_id', $order_details->customer_id)->delete();

                    // Log cart clearing for debugging
                    \Log::info("Payment Success - Cart cleared for customer {$order_details->customer_id}: {$deletedRows} items deleted (was {$cartItemsCount})");

                    // Verify cart is actually cleared
                    $remainingCartItems = Cart::where('customer_id', $order_details->customer_id)->count();
                    \Log::info("Verification - Remaining cart items for customer {$order_details->customer_id}: {$remainingCartItems}");

                    // Force immediate session update to reflect cart changes
                    $request->session()->forget('cart_count');
                    $request->session()->forget('cart_total');

                    // Commit the transaction
                    DB::commit();

                    // Refresh order details to get updated status
                    $order_details = $order_details->fresh();

                    // Debug: Add flash data to verify what happened
                    $debugInfo = "Cart had {$cartItemsCount} items, deleted {$deletedRows} rows, {$remainingCartItems} remaining for customer {$order_details->customer_id}";

                    // Instead of showing success view directly, redirect to cart page to see cleared cart
                    return redirect()->route('cart.index')
                        ->with('success', 'Payment successful! Your order has been confirmed and cart has been cleared.')
                        ->with('debug', $debugInfo);

                } catch (\Exception $e) {
                    // Rollback transaction on error
                    DB::rollback();
                    \Log::error("Payment Success - Cart clearing failed: " . $e->getMessage());
                    return redirect()->route('cart.index')->with('error', 'Payment successful but cart clearing failed. Please contact support.');
                }
            } else {
                return redirect()->route('cart.index')->with('error', 'Payment validation failed.');
            }
        } else if ($order_details->status == 'paid') {
            // Order already paid - ensure cart is cleared for this customer
            $cartItemsCount = Cart::where('customer_id', $order_details->customer_id)->count();
            $deletedRows = Cart::where('customer_id', $order_details->customer_id)->delete();

            // Log cart clearing for debugging
            \Log::info("Payment Already Completed - Cart cleared for customer {$order_details->customer_id}: {$deletedRows} items deleted (was {$cartItemsCount})");

            return redirect()->route('cart.index')
                ->with('success', 'Payment already completed! Your cart has been cleared.')
                ->with('debug', "Duplicate payment - cleared {$deletedRows} items for customer {$order_details->customer_id}");
        } else {
            return redirect()->route('cart.index')->with('error', 'Invalid transaction status: ' . $order_details->status);
        }
    }

    protected function validateTransaction($post_data, $tran_id, $amount, $currency)
    {
        $sslc = new SslCommerzNotification();

        // Create validation data
        $validation_data = [
            'store_id' => config('sslcommerz.apiCredentials.store_id'),
            'store_passwd' => config('sslcommerz.apiCredentials.store_password'),
            'val_id' => $post_data['val_id'] ?? '',
            'tran_id' => $tran_id,
            'amount' => $amount,
            'currency' => $currency,
        ];

        $response = $sslc->orderValidate($validation_data, 'sandbox', config('sslcommerz.apiCredentials.store_password'));

        if ($response) {
            $response_data = json_decode($response, true);

            if (isset($response_data['status']) && $response_data['status'] == 'VALID') {
                return true;
            }
        }

        return false;
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $auth_token = $request->input('auth_token');

        $order_details = Order::where('transaction_id', $tran_id)->first();

        if (!$order_details) {
            return redirect()->route('cart.index')->with('error', 'Invalid transaction.');
        }

        // If we have an auth_token in URL, verify it matches the order
        if ($auth_token && $order_details->auth_token !== $auth_token) {
            return redirect()->route('cart.index')->with('error', 'Invalid authentication token.');
        }

        // Get the customer for this order and re-authenticate if needed
        $customer = \App\Models\Customer::find($order_details->customer_id);
        if ($customer && (!Auth::guard('customer')->check() || Auth::guard('customer')->id() !== $customer->id)) {
            Auth::guard('customer')->login($customer, true);
            $request->session()->regenerate();
        }

        if ($order_details->status == 'pending') {
            $update_product = Order::where('transaction_id', $tran_id)
                ->update(['status' => 'failed']);

            return view('payment.fail', compact('order_details'));
        } else if ($order_details->status == 'paid') {
            return view('payment.success', compact('order_details'));
        } else {
            return redirect()->route('cart.index')->with('error', 'Transaction failed.');
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $auth_token = $request->input('auth_token');

        $order_details = Order::where('transaction_id', $tran_id)->first();

        if (!$order_details) {
            return redirect()->route('cart.index')->with('error', 'Invalid transaction.');
        }

        // If we have an auth_token in URL, verify it matches the order
        if ($auth_token && $order_details->auth_token !== $auth_token) {
            return redirect()->route('cart.index')->with('error', 'Invalid authentication token.');
        }

        // Get the customer for this order and re-authenticate if needed
        $customer = \App\Models\Customer::find($order_details->customer_id);
        if ($customer && (!Auth::guard('customer')->check() || Auth::guard('customer')->id() !== $customer->id)) {
            Auth::guard('customer')->login($customer, true);
            $request->session()->regenerate();
        }

        if ($order_details->status == 'pending') {
            $update_product = Order::where('transaction_id', $tran_id)
                ->update(['status' => 'cancelled']);

            return view('payment.cancel', compact('order_details'));
        } else if ($order_details->status == 'paid') {
            return view('payment.success', compact('order_details'));
        } else {
            return redirect()->route('cart.index')->with('error', 'Transaction cancelled.');
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payment information from the gateway
        if ($request->input('tran_id')) #Check transaction id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order table against the transaction id or order id.
            $order_details = Order::where('transaction_id', $tran_id)->first();

            if ($order_details->status == 'pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->total_amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also send sms or email for successful transaction to customer
                    */
                    $update_product = Order::where('transaction_id', $tran_id)
                        ->update([
                            'status' => 'paid',
                            'payment_method' => $request->input('card_type'),
                            'bank_tran_id' => $request->input('bank_tran_id'),
                            'card_type' => $request->input('card_type'),
                            'store_amount' => $request->input('store_amount')
                        ]);

                    // Clear customer's cart after successful payment
                    Cart::where('customer_id', $order_details->customer_id)->delete();

                    echo "SUCCESS";
                } else {
                    /*
                    That means IPN worked, but transaction validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = Order::where('transaction_id', $tran_id)
                        ->update(['status' => 'failed']);

                    echo "FAILED";
                }

            } else if ($order_details->status == 'paid') {

                #That means Order status already updated. No need to update database.
                echo "ALREADY SUCCESS";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.
                echo "INVALID TRANSACTION";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
