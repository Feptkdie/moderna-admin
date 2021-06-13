@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <a href="{{ route("permissions.create") }}" class="btn btn-success rounded-pill">Create permisison</a>

            <h4 class="card-title mt-3">
                Permissions <small class="text-muted">(0)</small>
            </h4>

            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Group</th>
                    <th>Action</th>
                </tr>
                @foreach ($permissions as $groupName => $permission)
                    <tr style="background-color: rgba(0,0,0, 0.05)">
                        <td colspan="4">Table: {{ $groupName }}</td>
                    </tr>
                    @foreach($permission as $data)
                        <tr>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->group_name }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route("permissions.edit", $data->id) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>

    {{-- <div class="mt-3 mb-3">
        {!! $permissions->links() !!}
    </div> --}}
</div>
@endsection