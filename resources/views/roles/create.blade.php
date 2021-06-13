@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
           <li class="breadcrumb-item " aria-current="page">Role create</li>
        </ol>
     </nav>

    <h3>Create New Role</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name">
        </div>

        <div class="form-group">
            <label for="permission">Permissions:</label>  
            <ul>
                @foreach($permissions as $groupName => $permission)
                    <li>
                        {{ $groupName }}
                        @foreach ($permission as $data)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="permissions[]" class="custom-control-input" id="customCheck{{ $data->id }}" value="{{ $data->id }}">
                                <label class="custom-control-label" for="customCheck{{ $data->id }}">
                                    {{ $data->description }}
                                </label>
                            </div>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection