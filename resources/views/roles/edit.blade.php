@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
           <li class="breadcrumb-item " aria-current="page">Role edit</li>
        </ol>
     </nav>

    <h3>{{ $role->name }}</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route("roles.update", $role->id) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $role->name }}">
        </div>

        <div class="form-group">
            <label for="permission">Permissions:</label>
            <ul>
                @foreach($permissions as $groupName => $permission)
                    <li>
                        {{ $groupName }}
                        @foreach ($permission as $perm)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" 
                                    name="permissions[]" 
                                    class="custom-control-input" 
                                    id="customCheck{{ $perm->id }}" 
                                    value="{{ $perm->id }}"
                                    {{ in_array($perm->id, $role->permissions->pluck("id")->toArray()) ? "checked" : "" }}
                                >
                                <label class="custom-control-label" for="customCheck{{ $perm->id }}">
                                    {{ $perm->name }}
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