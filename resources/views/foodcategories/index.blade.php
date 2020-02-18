@extends('orders.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="btn btn-info" href="{{ url('/') }}">Back</a>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('foodcategories.create') }}"> Create New FoodCategory</a>
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
            <th>Imagen</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($foodcategories as $foodcategory)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $foodcategory->name }}</td>
            <td><image src="{{ $foodcategory->getFirstMedia('images')->getFullUrl()}}" width="150"></td>
            <td>
                <form action="{{ route('foodcategories.destroy', $foodcategory->id) }}" method="POST"> 
                    <a class="btn btn-primary" href="{{ route('foodcategories.edit',$foodcategory->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $foodcategories->links() !!}
      
@endsection