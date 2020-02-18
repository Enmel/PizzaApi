<?php

namespace App\Http\Controllers\API;

use App\Food;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection as OrdersResource;
use App\Order;
use App\OrderDetail;
use App\OrderVoucher;
use App\Http\Resources\OrderVoucherCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\AllowedFilter;
//Spatie uses
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Spatie\QueryBuilder\Exceptions\InvalidSortQuery;
use Spatie\QueryBuilder\QueryBuilder;
use Validator;

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

        try{
            $orders = QueryBuilder::for(Order::where('user_id', $user_id))
                    ->allowedFilters([AllowedFilter::exact('status'), AllowedFilter::exact('paidout'), AllowedFilter::exact('type')])
                    ->defaultSort('id')
                    ->allowedSorts('created_at')
                    ->paginate(15)
                    ->appends(request()->query());

        }catch(InvalidFilterQuery $e){
            return $this->sendError('Filtro invalido', $e->getMessage());
        }catch(InvalidSortQuery $e){
            return $this->sendError('Sort invalido', $e->getMessage());
        }

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
            'details.*.size' => [
                'required',
                Rule::in(['very_small','small', 'medium', 'large', 'very_large']),
            ],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user_id = Auth::id();

        $order = Order::create([
            'user_id' => $user_id,
            'type' => $input['type'],
            'paidout' => 0,
            'status' => 'pending',
        ]);

        $orderDetails = [];

        foreach ($input['details'] as $detail) {

            $food = Food::find($detail['food_id']);
            $detail['total'] = $detail['quantity'] * $food->{$detail['size']."_price"};
            $detail['order_id'] = $order->id;

            OrderDetail::create($detail);
        }

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if($order->vouchers->where('paidout', '=', 1)->sum('amount') > $order->details->sum('total')){
            return $this->sendError('No puedes cancelar la orden', 'Orden en proceso. No se puede cancelar');
        }

        $order->delete();

        return $this->sendResponse([], 'Order deleted successfully.');
    }

    public function addVoucher(Request $request, Order $order) {

        $input = $request->all();

        $validator = Validator::make($input, [
            'bank' => 'required|string|max:250',
            'amount' => 'required|numeric',
            'reference' => 'required|string|max:250',
        ]);

        /* 'bank' => [
            'required',
            Rule::in(['pickup', 'delivery']),
        ], */

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $voucher = new OrderVoucher([
            'bank' => $input['bank'],
            'reference' => $input['reference'],
            'amount' => $input['amount'],
            'comments' => $input['comments']
        ]);

        $order->vouchers()->save($voucher);

        return $this->sendResponse([], 'Voucher agregado exitosamente.');
    }

    public function getVouchers(Request $request) {

        $user_id = Auth::id();

        try{
            $orders = QueryBuilder::for( OrderVoucher::whereHas('order', function ($q) use($user_id) {
                    $q->where('user_id', '=', $user_id);
            }))
                    ->allowedFilters([AllowedFilter::exact('order_id'), AllowedFilter::exact('paidout'), AllowedFilter::exact('amount')])
                    ->defaultSort('id')
                    ->allowedSorts('created_at')
                    ->paginate(15)
                    ->appends(request()->query());

        }catch(InvalidFilterQuery $e){
            return $this->sendError('Filtro invalido', $e->getMessage());
        }catch(InvalidSortQuery $e){
            return $this->sendError('Sort invalido', $e->getMessage());
        }

        return new OrderVoucherCollection($orders);

        return $this->sendResponse([], 'Voucher agregado exitosamente.');
    }
}
