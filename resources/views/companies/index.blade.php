@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @can("users-create")
                <a href="{{ route("companies.create") }}" class="btn btn-success rounded-pill mb-3">Create company</a>
            @endcan
            
            <h4 class="card-title">
                Companies <small class="text-muted">({{ count($companies) }})</small>
            </h4>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Categories</th>
                    <th>Logo</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>
                            @foreach($company->categories as $category)
                                <h5><span class="badge badge-secondary">{{ $category->name }}</span></h5>
                            @endforeach
                        </td>
                        <td>
                            @if (!empty($company->logo))
                                <img src="{{ $company->logo }}" class="img-fluid" style="max-width: 100px;" />
                            @endif
                        </td>
                        <td>{{ $company->created_at }}</td>
                        <td>
                            {{-- @can("companies-list")
                                <a class="btn btn-info" href="{{ route("companies.show", $company->id) }}">Show</a>
                            @endcan  --}}
                            @can("companies-edit")
                                <a class="btn btn-primary" href="{{ route("companies.edit", $company->id) }}">Edit</a>
                            @endcan
                            @can("companies-delete")
                                <confirm-delete
                                    :data-id="{{ json_encode($company->id) }}" 
                                    :data-title="{{ json_encode($company->name) }}" 
                                    :data-url="{{ json_encode('/companies/' . $company->id) }}" 
                                    data-redirect-url="/companies">
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