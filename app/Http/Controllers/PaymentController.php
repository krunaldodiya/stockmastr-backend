<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PaytmWallet;
use App\User;
use Exception;
use App\Events\UpdateOrderStatus;
use App\Http\Requests\ProcessOrder;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $user_id = $request->user_id;

        if ($user_id) {
            session(['user_id' => $user_id]);

            $user = User::find($user_id);

            return view('payments.show', compact('user'));
        }

        abort('404');
    }

    public function processOrder(ProcessOrder $request)
    {
        $user_id = session('user_id');
        $mobile = $request->mobile;
        $amount = $request->amount;

        $user = User::find($user_id);
        $transaction = $user->createTransaction($amount, 'deposit', ['description' => 'Money Deposited to wallet.']);

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => $transaction['transaction_id'],
            'amount' => $amount,
            'user' => $user['id'],
            'email' => $user['email'],
            'mobile_number' => $mobile,
            'callback_url' => route('paytm.order-response')
        ]);

        return $payment->receive();
    }

    public function orderResponse(Request $request)
    {
        $response = $request->all();
        $user = User::find(session('user_id'));

        $wallet = $user->wallet;
        $transactions = $wallet->transactions;

        $statuses = [
            'TXN_SUCCESS' => 'success',
            'TXN_FAILED' => 'failed',
            'TXN_PENDING' => 'pending',
        ];

        $order = $user->deposit($response['ORDERID'], $statuses[$response['STATUS']]);

        UpdateOrderStatus::dispatch($user);

        return redirect()->route('payments.order-status', ['transaction_id' => $order->transaction_id]);
    }

    public function orderStatus(Request $request)
    {
        $user = User::find(session('user_id'));
        $order = $user->getOrderById($request->transaction_id);

        return view('payments.response')->with(compact('user', 'order'));
    }
}
