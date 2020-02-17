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
            <th>Orden de Pago</th>
            <th>Referencia</th>
            <th>Banco</th>
            <th>Status</th>
            <th>Monto</th>
        </tr>
        @foreach ($order->vouchers as $voucher)
        <tr>
            <td>{{$voucher->id }}</td>
            <td>{{$voucher->reference}}</td>
            <td>{{$voucher->bank}}</td>
            @if ($voucher->paidout == 0)
                <td><a href="{{ route('orders.confirmPaid', ['order'=> $order->id,'ordervoucher'=>$voucher->id]) }}" class="badge badge-warning">Pendiente</a></td>
            @else
                <td><div class="badge badge-success">Confirmado</div></td>
            @endif
            <td>{{$voucher->amount}}</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Total:</th>
            <td>{{$order->vouchers->sum('amount')}}</td>
        </tr>
    </table>
   
@endsection