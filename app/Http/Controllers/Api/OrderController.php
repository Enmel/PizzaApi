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
        $orders = Order::all();
        return $this->sendResponse(new OrdersResource($orders), 'Orders retrieved successfully.');
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
    public function show($id)
    {
        $table = Table::find($id);

        if (is_null($table)) {
            return $this->sendError('Table not found.');
        }

        return $this->sendResponse(new TableResource($table), 'Table retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Table $table)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|max:256|string',
            'chairs' => 'required|integer',
            'description' => 'max:512|string|nullable'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $table->save($input);

        return $this->sendResponse(new TableResource($table), 'Table updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return $this->sendResponse([], 'Table deleted successfully.');
    }
}
