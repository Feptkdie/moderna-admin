@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @can("users-create")
                <a href="{{ route("roles.create") }}" class="btn btn-success rounded-pill">Create role</a>
            @endcan
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">
                Roles <small class="text-muted">({{ count($roles) }})</small>
            </h4>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if ($role->permissions->count() > 0)
                            <h5>
                                <span class="badge badge-light">
                                    {{ $role->permissions->count() }} permissions
                                </span>
                            </h5>
                        @else 
                        <h5>
                            <span class="badge badge-warning">
                                no permissions
                            </span>
                        </h5>
                        @endif
                        
                    </td>
                    <td>
                        @can("users-list")
                            <a class="btn btn-info" href="{{ route("roles.show", $role->id) }}">Show</a>
                        @endcan 
                        @can("users-edit")
                            <a class="btn btn-primary" href="{{ route("roles.edit", $role->id) }}">Edit</a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection