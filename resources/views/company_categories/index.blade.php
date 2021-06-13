@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @can("users-create")
                <a href="{{ route("company-categories.create") }}" class="btn btn-success rounded-pill mb-3">Create category</a>
            @endcan
            
            <h4 class="card-title">
                Company categories <small class="text-muted">({{ count($categories) }})</small>
            </h4>
            
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if (!empty($category->image))
                                <img src="{{ $category->image }}" class="img-fluid" style="max-width: 100px;" />
                            @endif
                        </td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            {{-- @can("company-categories-list")
                                <a class="btn btn-info" href="{{ route("company-categories.show", $category->id) }}">Show</a>
                            @endcan  --}}
                            @can("company-categories-edit")
                                <a class="btn btn-primary" href="{{ route("company-categories.edit", $category->id) }}">Edit</a>
                            @endcan
                            @can("company-categories-delete")
                                <confirm-delete
                                    :data-id="{{ json_encode($category->id) }}" 
                                    :data-title="{{ json_encode($category->name) }}" 
                                    :data-url="{{ json_encode('/company-categories/' . $category->id) }}" 
                                    data-redirect-url="/company-categories">
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