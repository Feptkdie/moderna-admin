@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")
    
    <div class="card border-0 shadow-sm">
        
        <div class="card-body">
            @can("users-create")
                <a href="{{ route("infos.create") }}" class="btn btn-success rounded-pill mb-3">Create info</a>
            @endcan
            
            <h4 class="card-title">
                Products <small class="text-muted">({{ count($infos) }})</small>
            </h4>
            <table class="table table-striped">
                <tr>
                    <th>Title</th>
                    <th>Download Count</th>
                    <th>View Count</th>
                    <th>Categories</th>
                    <th>Mode</th>
                    <th>File</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                @foreach ($infos as $info)
                    <tr>
                        <td>{{ $info->title }}</td>
                        <td>{{ $info->download_count }}</td>
                        <td>{{ $info->view_count }}</td>
                        <td>
                            @foreach($info->categories as $category)
                                <h5><span class="badge badge-secondary">{{ $category->name }}</span></h5>
                            @endforeach
                        </td>
                        <td>{{ $info->file_mode }}</td>
                        <td>
                            @if ($info->file_mode == "image")
                                @if ($info->file_path)
                                    <img src="{{ $info->file_path }}" class="img-fluid" style="max-width: 100px;">
                                @endif
                            @else
                                @if ($info->file_path)
                                    <iframe width="200" src="https://www.youtube.com/embed/{{ $info->file_path }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                    </iframe> 
                                @endif
                            @endif    
                        </td>
                        <td>{{ $info->created_at }}</td>
                        <td>
                            {{-- @can("infos-list")
                                <a class="btn btn-info" href="{{ route("infos.show", $info->id) }}">Show</a>
                            @endcan  --}}
                            @can("infos-edit")
                                <a class="btn btn-primary" href="{{ route("infos.edit", $info->id) }}">Edit</a>
                            @endcan
                            @can("infos-delete")
                                <confirm-delete
                                    :data-id="{{ json_encode($info->id) }}" 
                                    :data-title="{{ json_encode($info->title) }}" 
                                    :data-url="{{ json_encode('/infos/' . $info->id) }}" 
                                    data-redirect-url="/infos">
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