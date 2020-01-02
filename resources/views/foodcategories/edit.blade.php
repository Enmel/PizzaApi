@extends('foodcategories.layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Table</h2>
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
	<form action="{{ route('foodcategories.update', $foodcategory->id) }}" method="POST" enctype="multipart/form-data">
	    @csrf
        @method('PUT')
	   
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" value="{{ $foodcategory->name }}"  class="form-control mt-2" placeholder="Nombre">
                    <input type="file" name="image" class="form-control mt-2">
                </div>
            </div>
            <image src="{{ $foodcategory->getFirstMedia('images')->getFullUrl()}}" width="150">
            <span>Nota: esta es la imagen actual</span>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
	   
	</form>
@endsection