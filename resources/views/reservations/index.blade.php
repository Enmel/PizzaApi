@extends('orders.layout')
 
@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($message = Session::get('danger'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Personas</th>
            <th>Comments</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($reservations as $reservation)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $reservation->user->name }}</td>
            <td>{{ $reservation->date }}</td>
            <td>{{ $reservation->seats }}</td>
            <th>{{ $reservation->comments }}</th>
            @if ($reservation->status == 'pending')
                <td><a href="{{ route('reservations.status', $reservation->id) }}" class="badge badge-warning">Pendiente</a></td>
            @elseif($reservation->status == 'rejected')
                <td><a href="{{ route('reservations.status', $reservation->id) }}" class="badge badge-danger">Rechazada</a></td>
            @else
                <td><a href="{{ route('reservations.status', $reservation->id) }}" class="badge badge-success">Confirmado</a></td>
            @endif
            <td>
                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST"> 
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $reservations->links() !!}
      
@endsection