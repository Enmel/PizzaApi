<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(15);

        return view('orders.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function paidout(Order $order)
    {
        $order->paidout = (integer) !$order->paidout;
        $order->save();

        if ($order->paidout === 1) {
            return redirect()->route('orders.index')->with('success', 'Orden pagada!');
        }

        return redirect()->route('orders.index')->with('danger', 'Pago de orden cancelado');
    }

    public function status(Order $order)
    {
        if ($order->status === 'pending') {
            $order->status = 'accepted';
            $order->save();
            return redirect()->route('orders.index')->with('success', 'Orden aceptada. Esperando pago');
        }
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully');
    }
}
