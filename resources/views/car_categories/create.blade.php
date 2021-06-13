@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route("car-categories.index") }}">Car categories</a></li>
           <li class="breadcrumb-item " aria-current="page">Category create</li>
        </ol>
     </nav>

    <h3>Create Category</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route("car-categories.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <car-category-add :data-categories="{{ json_encode($categories) }}"></car-category-add>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection