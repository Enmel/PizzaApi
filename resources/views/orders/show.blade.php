@extends('orders.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Orden: {{$order->id}}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('orders.index') }}">Back</a>
            </div>
        </div>
    </div>
   
    <table class="table table-bordered">
        <tr>
            <th>Pedido</th>
            <th>Tamaño</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
        @foreach ($order->details as $detail)
        <tr>
            <td>{{$detail->food->name }}</td>
            <td>{{$detail->food->categorydata->{"$detail->size"."_label"} }}</td>
            <td>{{$detail->food->{"$detail->size"."_price"} }}</td>
            <td>{{$detail->quantity}}</td>
            <td>{{$detail->total}}</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Total:</th>
            <td>{{$order->details->sum('total')}}</td>
        </tr>
    </table>
   
@endsection