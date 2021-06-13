@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            {{-- <a href="{{ route("users.create") }}" class="btn btn-success rounded-pill">Create user</a> --}}

            <h4 class="card-title mt-3">
                Users <small class="text-muted">({{ $users->total() }})</small>
            </h4>

            <form class="form-inline mb-3" method="GET" action="{{ route("users.index") }}">
                <input type="text" class="form-control mb-2 mr-sm-2" name="lastname" placeholder="Lastname" value="{{ request("lastname") }}">
                <input type="text" class="form-control mb-2 mr-sm-2" name="firstname" placeholder="Firstname" value="{{ request("firstname") }}">
                <input type="text" class="form-control mb-2 mr-sm-2" name="email" placeholder="Email" value="{{ request("email") }}">
                <button type="submit" class="btn btn-primary mb-2 mr-2">Search</button>
                <a href="{{ route("users.index") }}" class="btn btn-danger mb-2">Clear</a>
            </form>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->lastname }} {{ $user->firstname }}</td>
                            <td>{{ $user->email }}</td>
                            {{-- <td>
                                @if (count($user->roles) == 0) 
                                    <h5><span class="badge badge-warning">no role</span></h5>
                                @else
                                    <h5><span class="badge badge-light">{{ count($user->roles) }} roles</span></h5>
                                @endif
                                @if (count($user->permissions) == 0) 
                                    <h5><span class="badge badge-warning">no permission</span></h5>
                                @else
                                    <h5><span class="badge badge-light">{{ count($user->permissions) }} permissions</span></h5>
                                @endif
                            </td> --}}
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @can("users-edit")
                                    <a class="btn btn-primary" href="{{ route("users.edit", $user->id) }}">Edit</a>
                                @endcan
                                @can("users-delete")
                                    <confirm-delete
                                        :data-id="{{ json_encode($user->id) }}" 
                                        :data-title="{{ json_encode($user->email) }}" 
                                        :data-url="{{ json_encode('/users/' . $user->id) }}" 
                                        data-redirect-url="/users">
                                    </confirm-delete>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 mb-3">
        {!! $users->links() !!}
    </div>
</div>
@endsection