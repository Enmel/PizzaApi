@extends('foods.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Food</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('foods.index') }}"> Back</a>
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
   
<form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="name" class="form-control" placeholder="Nombre">
            </div>
            <div class="form-group">
                <strong>Size:</strong>
                <select name="size" class="form-control">
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="big">Big</option>
                </select>
            </div>
            <div class="form-group">
                <strong>Price:</strong>
                <input type="number" name="price" step=".01" class="form-control" placeholder="Precio">
            </div>
            <div class="form-group">
                <strong>Descripcion:</strong>
                <textarea name="description" class="form-control" placeholder="Descripcion" maxlength="256">
                </textarea>
            </div>
            <div class="form-group">
                <strong>Categoria:</strong>
                <select name="category" class="form-control">
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="file" name="image" class="form-control mt-2">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection