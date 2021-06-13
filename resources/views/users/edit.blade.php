@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Home</a></li>
           <li class="breadcrumb-item"><a href="{{ route("users.index") }}">Users</a></li>
           <li class="breadcrumb-item " aria-current="page">User edit</li>
        </ol>
    </nav>

    <h3>{{ $user->name }}</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route("users.update", $user->id) }}" method="POST">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="lastname">Lastname:</label>
            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Lastname" value="{{ $user->lastname }}">
        </div>

        <div class="form-group">
            <label for="firstname">Firstname:</label>
            <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Firstname" value="{{ $user->firstname }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="email" value="{{ $user->email }}">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>

        <div class="form-group">
            <label for="password2">Password confirm:</label>
            <input type="password" name="password_confirmation" class="form-control" id="password2">
        </div>
       
        <div class="form-group">
            <label for="roles">Roles:</label>
            <select name="role" class="form-control" id="roles">
                <option value="">-- Select --</option>
                @foreach ($roles as $role)
                    <option 
                        value="{{ $role->id }}"
                        {{ in_array($role->id, $user->roles->pluck("id")->toArray()) ? "selected" : "" }}
                    >
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Permissions</label>
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
                                    {{ in_array($perm->id, $user->permissions->pluck("id")->toArray()) ? "checked" : "" }}
                                >
                                <label class="custom-control-label" for="customCheck{{ $perm->id }}">
                                    {{ $perm->description }}
                                </label>
                            </div>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection