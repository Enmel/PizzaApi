@extends('orders.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('foods.create') }}"> Agregar Comida</a>
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
            <th>Categoria</th>
            <th>Imagen</th>
            <th width="280px">Accion</th>
        </tr>
        @foreach ($foods as $food)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $food->name }}</td>
            <td>{{ $food->categorydata->name }}</td>
            <td><image src="{{ $food->getFirstMedia('images')->getFullUrl()}}" width="100"></td>
            <td>
                <form action="{{ route('foods.destroy', $food->id) }}" method="POST"> 
                    <a class="btn btn-primary" href="{{ route('foods.edit',$food->id) }}"><i class="fas fa-pencil-alt"></i></a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $foods->links() !!}
      
@endsection