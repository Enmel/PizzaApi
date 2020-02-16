@extends('orders.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="btn btn-info" href="{{ url('/') }}">Back</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
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
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"> 
                    <a class="btn btn-primary" href="{{ route('orders.show', $order->id) }}"><i class="fas fa-eye"></i></a>

                    @if (count($order->vouchers) > 0)
                        <a class="btn btn-info" href="{{ route('orders.vouchers', $order->id) }}"><i class="far fa-credit-card"></i></a>
                    @endif
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $orders->links() !!}
      
@endsection