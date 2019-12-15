@extends('tables.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tu pedido logo</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('tables.create') }}"> Create New Table</a>
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
            <th width="280px">Action</th>
        </tr>
        @foreach ($tables as $table)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $table->name }}</td>
            <td>{{ $table->chairs }}</td>
            <td>
                <form action="{{ route('tables.destroy',$table->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('tables.show',$table->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('tables.edit',$table->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $tables->links() !!}
      
@endsection