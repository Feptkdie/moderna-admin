@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")
    
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @can("notes-create")
                <a href="{{ route("notes.create") }}" class="btn btn-success rounded-pill">Create sos</a>
            @endcan
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">
                List of SOS <small class="text-muted">({{ count($notes) }})</small>
            </h4>
            <table class="table table-striped">
                <tr>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                @foreach ($notes as $key => $note)
                    <tr>
                        <td>{{ $note->category ? $note->category->name : "" }}</td>
                        <td>{{ $note->title }}</td>
                        <td>{{ $note->phone }}</td>
                        <td>{{ $note->address }}</td>
                        <td>
                            {{-- @can("notes-list")
                                <a class="btn btn-info" href="{{ route("notes.show", $note->id) }}">Show</a>
                            @endcan  --}}
                            @can("notes-edit")
                                <a class="btn btn-primary" href="{{ route("notes.edit", $note->id) }}">Edit</a>
                            @endcan
                            @can("notes-delete")
                                <confirm-delete
                                    :data-id="{{ json_encode($note->id) }}" 
                                    :data-title="{{ json_encode($note->title) }}" 
                                    :data-url="{{ json_encode('/notes/' . $note->id) }}" 
                                    data-redirect-url="/notes">
                                </confirm-delete>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection