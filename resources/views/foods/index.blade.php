@extends('foods.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="btn btn-info" href="{{ url('/') }}">Back</a>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('foods.create') }}"> Create New Food</a>
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
            <th>Descripcion</th>
            <th>Size</th>
            <th>Category</th>
            <th>Price</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($foods as $food)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $food->name }}</td>
            <td>{{ $food->description }}</td>
            <td>{{ $food->size }}</td>
            <td>{{ $food->categorydata->name }}</td>
            <td>{{ $food->price }}</td>
            <td>
                <form action="{{ route('foods.destroy', $food->id) }}" method="POST"> 
                    <a class="btn btn-primary" href="{{ route('foods.edit',$food->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $foods->links() !!}
      
@endsection