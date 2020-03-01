@extends('orders.layout')
 
@section('content')
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div>
        <a class="{{ Route::current()->getName() == 'orders.index' ? 'btn btn-primary' : 'btn btn-secondary' }}" href="{{ route('orders.index') }}"> Todas </a>
        <a class="{{ Route::current()->getName() == 'orders.actualDay' ? 'btn btn-primary' : 'btn btn-secondary' }}" href="{{ route('orders.actualDay') }}"> Hoy </a>
        <a class="{{ Route::current()->getName() == 'orders.actualMonth' ? 'btn btn-primary' : 'btn btn-secondary' }}" href="{{ route('orders.actualMonth') }}"> Mes </a>
        <a class="{{ Route::current()->getName() == 'orders.actualYear' ? 'btn btn-primary' : 'btn btn-secondary' }}" href="{{ route('orders.actualYear') }}"> Año </a>
    </div>
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Pagado</th>
            <th>Status</th>
            <th>Total</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->created_at }}</td>
            @if ($order->vouchers->where('paidout', '=', 1)->sum('amount') > $order->details->sum('total'))
                <td><div class="badge badge-success">Confirmado</div></td>
            @else
                <td><div class="badge badge-warning">Pendiente</div></td>
            @endif
            @if ($order->status == "pending")
                <td><a href="{{ route('orders.status', $order->id) }}" class="badge badge-warning">Pendiente</a></td>
            @else
                <td><a href="{{ route('orders.status', $order->id) }}" class="badge badge-success">Confirmado</a></td>
            @endif
            <td>{{$order->details->sum('total')}}</td>
            <td>
                <form > 
                    <a class="btn btn-primary" href="{{ route('orders.show', $order->id) }}"><i class="fas fa-eye"></i></a>

                    @if (count($order->vouchers) > 0)
                        <a class="btn btn-info" style="color: #fff !important;" href="{{ route('orders.vouchers', $order->id) }}"><i class="fas fa-money-check-alt"></i></a>
                    @endif
   
                    @csrf
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $orders->links() !!}
      
@endsection