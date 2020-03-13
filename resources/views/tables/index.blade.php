@extends('orders.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('tables.create') }}"> Agregar Mesa</a>
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
            <th>Sillas</th>
            <th width="280px">Accion</th>
        </tr>
        @foreach ($tables as $table)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $table->name }}</td>
            <td>{{ $table->chairs }}</td>
            <td>
                <form action="{{ route('tables.destroy',$table->id) }}" method="POST">
   
                    <a class="btn btn-primary" href="{{ route('tables.show',$table->id) }}"><i class="fas fa-eye"></i></a>
    
                    <a class="btn btn-info" style="color: #fff !important;" href="{{ route('tables.edit',$table->id) }}"><i class="fas fa-pencil-alt"></i></a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $tables->links() !!}
      
@endsection