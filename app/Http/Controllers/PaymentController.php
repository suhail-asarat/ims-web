<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Library\SslCommerzNotification;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        Log::info('Payment Success Callback', $request->all());

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        // Validate the payment with SSLCommerz
        $validation = $this->validatePayment($request->all());

        if ($validation['status'] === 'VALID') {
            // Find the order by transaction ID
            $order = Order::where('transaction_id', $tran_id)->first();

            if ($order) {
                // Verify the amount matches
                if (abs($order->total_amount - floatval($amount)) < 0.01) {
                    // Update order status to paid
                    $order->update([
                        'status' => 'paid',
                        'bank_tran_id' => $request->input('bank_tran_id'),
                        'card_type' => $request->input('card_type'),
                        'store_amount' => $request->input('store_amount'),
                        'payment_method' => $request->input('card_type') ?? 'online'
                    ]);

                    Log::info("Order {$tran_id} marked as paid successfully");

                    return redirect()->route('payment.success.page', ['order' => $order->id])
                        ->with('success', 'Payment completed successfully!');
                } else {
                    Log::error("Amount mismatch for order {$tran_id}. Expected: {$order->total_amount}, Received: {$amount}");
                    return redirect()->route('payment.failed.page')
                        ->with('error', 'Payment amount mismatch. Please contact support.');
                }
            } else {
                Log::error("Order not found for transaction ID: {$tran_id}");
                return redirect()->route('payment.failed.page')
                    ->with('error', 'Order not found. Please contact support.');
            }
        } else {
            Log::error("Payment validation failed for transaction: {$tran_id}", $validation);
            return redirect()->route('payment.failed.page')
                ->with('error', 'Payment validation failed. Please try again.');
        }
    }

    public function fail(Request $request)
    {
        Log::info('Payment Failed Callback', $request->all());

        $tran_id = $request->input('tran_id');

        // Find and update order status to failed
        $order = Order::where('transaction_id', $tran_id)->first();
        if ($order) {
            $order->update([
                'status' => 'failed',
                'bank_tran_id' => $request->input('bank_tran_id'),
            ]);

            Log::info("Order {$tran_id} marked as failed");
        }

        return redirect()->route('payment.failed.page')
            ->with('error', 'Payment failed. Please try again.');
    }

    public function cancel(Request $request)
    {
        Log::info('Payment Cancelled Callback', $request->all());

        $tran_id = $request->input('tran_id');

        // Find and update order status to cancelled
        $order = Order::where('transaction_id', $tran_id)->first();
        if ($order) {
            $order->update([
                'status' => 'cancelled'
            ]);

            Log::info("Order {$tran_id} marked as cancelled");
        }

        return redirect()->route('payment.cancelled.page')
            ->with('info', 'Payment was cancelled.');
    }

    public function ipn(Request $request)
    {
        Log::info('Payment IPN Callback', $request->all());

        $tran_id = $request->input('tran_id');
        $status = $request->input('status');
        $amount = $request->input('amount');

        // Validate the payment with SSLCommerz
        $validation = $this->validatePayment($request->all());

        if ($validation['status'] === 'VALID' && $status === 'VALID') {
            // Find the order by transaction ID
            $order = Order::where('transaction_id', $tran_id)->first();

            if ($order && $order->status !== 'paid') {
                // Verify the amount matches
                if (abs($order->total_amount - floatval($amount)) < 0.01) {
                    // Update order status to paid
                    $order->update([
                        'status' => 'paid',
                        'bank_tran_id' => $request->input('bank_tran_id'),
                        'card_type' => $request->input('card_type'),
                        'store_amount' => $request->input('store_amount'),
                        'payment_method' => $request->input('card_type') ?? 'online'
                    ]);

                    Log::info("Order {$tran_id} marked as paid via IPN");
                }
            }
        }

        return response('OK', 200);
    }

    private function validatePayment($post_data)
    {
        $sslc = new SslCommerzNotification();

        $validation_data = [
            'val_id' => $post_data['val_id'] ?? '',
            'store_id' => config('sslcommerz.apiCredentials.store_id'),
            'store_passwd' => config('sslcommerz.apiCredentials.store_password'),
            'format' => 'json'
        ];

        $host_type = config('sslcommerz.connect_from_localhost') ? 'sandbox' : 'live';

        $response = $sslc->orderValidate(
            $validation_data,
            $host_type,
            config('sslcommerz.apiCredentials.store_password')
        );

        return json_decode($response, true) ?? ['status' => 'INVALID'];
    }

    // Display pages for different payment outcomes
    public function successPage($orderId)
    {
        $order = Order::with('customer')->findOrFail($orderId);
        return view('payment.success', compact('order'));
    }

    public function failedPage()
    {
        return view('payment.failed');
    }

    public function cancelledPage()
    {
        return view('payment.cancelled');
    }

    public function checkPaymentStatus($transactionId)
    {
        $order = Order::where('transaction_id', $transactionId)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Double-check payment status with SSLCommerz
        $validation = $this->validatePaymentByTransactionId($transactionId);

        if ($validation['status'] === 'VALID' && $order->status !== 'paid') {
            $order->update([
                'status' => 'paid',
                'bank_tran_id' => $validation['bank_tran_id'] ?? null,
                'card_type' => $validation['card_type'] ?? null,
                'store_amount' => $validation['store_amount'] ?? null,
            ]);
        }

        return response()->json([
            'transaction_id' => $order->transaction_id,
            'status' => $order->status,
            'amount' => $order->total_amount
        ]);
    }

    private function validatePaymentByTransactionId($transactionId)
    {
        $sslc = new SslCommerzNotification();

        $validation_data = [
            'tran_id' => $transactionId,
            'store_id' => config('sslcommerz.apiCredentials.store_id'),
            'store_passwd' => config('sslcommerz.apiCredentials.store_password'),
            'format' => 'json'
        ];

        $host_type = config('sslcommerz.connect_from_localhost') ? 'sandbox' : 'live';
        $url = $host_type === 'sandbox'
            ? "https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php"
            : "https://securepay.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        $query = http_build_query($validation_data);
        curl_setopt($curl, CURLOPT_URL, $url . '?' . $query);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error("SSLCommerz validation error: " . $err);
            return ['status' => 'ERROR'];
        }

        return json_decode($response, true) ?? ['status' => 'INVALID'];
    }
}
