<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Food;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection as OrdersResource;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->paginate(15);

        return new OrdersResource($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'type' => [
                'required',
                Rule::in(['pickup', 'delivery']),
            ],
            'details.*.food_id' => 'required|exists:App\Food,id|integer',
            'details.*.quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user_id = Auth::id();

        $order = Order::create([
            'user_id' => $user_id,
            'type' => $input['type'],
            'paidout' => 0,
            'status' => 'pending'
        ]);

        $orderDetails = [];

        foreach ($input['details'] as $detail) {

            $food = Food::find($detail['food_id']);
            $detail['total'] = $detail['quantity'] * $food->price;
            $detail['order_id'] = $order->id;

            OrderDetail::create($detail);
        }


        return $this->sendResponse(new OrderResource($order), 'Orden created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        return $this->sendResponse(new OrderResource($order), 'Order retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return $this->sendResponse([], 'Order deleted successfully.');
    }
}
