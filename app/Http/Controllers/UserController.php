<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Models\Transaction;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }
    

    public function account_orders()
    {
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
        return view('user.orders',compact('orders'));
        }
    public function account_order_details($order_id)
{


        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();   
        if($order){

            $orderitems = Order::where('id', $order->id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('id',$order_id)->first();
            return view('user.order-details',compact('order', 'orderitems', 'transaction'));
        } else {
            return redirect()->route('login');
        }
}
}
