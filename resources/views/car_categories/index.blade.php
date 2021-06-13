@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @can("users-create")
                <a href="{{ route("car-categories.create") }}" class="btn btn-success rounded-pill mb-3">Create category</a>
            @endcan
            
            <h4 class="card-title">
                Car categories <small class="text-muted">({{ count($categories) }})</small>
            </h4>
            
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @can("car-categories-edit")
                                <a class="btn btn-primary" href="{{ route("car-categories.edit", $category->id) }}">Edit</a>
                            @endcan
                            @can("car-categories-delete")
                                <confirm-delete
                                    :data-id="{{ json_encode($category->id) }}" 
                                    :data-title="{{ json_encode($category->name) }}" 
                                    :data-url="{{ json_encode('/car-categories/' . $category->id) }}" 
                                    data-redirect-url="/car-categories">
                                </confirm-delete>
                            @endcan
                        </td>
                    </tr>
                    @foreach ($category->childrenCategories as $childCat1)
                        <tr>
                            <td style="padding-left:25px;">--> {{ $childCat1->name }}</td>
                            <td>
                                @can("car-categories-edit")
                                    <a class="btn btn-primary" href="{{ route("car-categories.edit", $childCat1->id) }}">Edit</a>
                                @endcan
                                @can("car-categories-delete")
                                    <confirm-delete
                                        :data-id="{{ json_encode($childCat1->id) }}" 
                                        :data-title="{{ json_encode($childCat1->name) }}" 
                                        :data-url="{{ json_encode('/car-categories/' . $childCat1->id) }}" 
                                        data-redirect-url="/car-categories">
                                    </confirm-delete>
                                @endcan
                            </td>
                        </tr>
                        @foreach ($childCat1->childrenCategories as $childCat2)
                            <tr>
                                <td style="padding-left:55px;">--> {{ $childCat2->name }}</td>
                                <td>
                                    @can("car-categories-edit")
                                        <a class="btn btn-primary" href="{{ route("car-categories.edit", $childCat2->id) }}">Edit</a>
                                    @endcan
                                    @can("car-categories-delete")
                                        <confirm-delete
                                            :data-id="{{ json_encode($childCat2->id) }}" 
                                            :data-title="{{ json_encode($childCat2->name) }}" 
                                            :data-url="{{ json_encode('/car-categories/' . $childCat2->id) }}" 
                                            data-redirect-url="/car-categories">
                                        </confirm-delete>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection