@extends('orders.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New FoodCategory</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('foodcategories.index') }}"> Back</a>
        </div>
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('foodcategories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="name" class="form-control" placeholder="Nombre">
                <input type="file" name="image" class="form-control mt-2">
            </div>
            <div class="form-group">
                <strong>Etiquetas de tamaños:</strong>
                <input type="text" name="very_small_label" class="form-control" placeholder="Muy pequeño">
                <input type="text" name="small_label" class="form-control" placeholder="Pequeño">
                <input type="text" name="medium_label" class="form-control" placeholder="Mediano">
                <input type="text" name="large_label" class="form-control" placeholder="Grande">
                <input type="text" name="very_large_label" class="form-control" placeholder="Muy grande">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection