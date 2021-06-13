@extends("layouts.app")

@section("content")
<div class="container">
    @include("flash_message")
    
    <div class="card border-0 shadow-sm">
        
        <div class="card-body">
            @can("users-create")
                <a href="{{ route("cars.create") }}" class="btn btn-success rounded-pill mb-3">Машин нэмэх</a>
            @endcan
            
            <h4 class="card-title">
                Машинууд <small class="text-muted">({{ count($cars) }})</small>
            </h4>
            <table class="table table-striped">
                <tr>
                    <th>Зураг</th>
                    <th>Нэр</th>
                    <th>Бүлэг</th>
                    <th>Үйлдвэрлэгч</th>
                    <th>Загвар</th>
                    <th>Орж ирсэн он</th>
                    <th>Үйлдвэрлэсэн он</th>
                    <th>Үнэ</th>
                    <th>Борлуулагч</th>
                    <th></th>
                </tr>
                @foreach ($cars as $car)
                    <tr>
                        <td>
                            @if (count($car->images) > 0) 
                                <img src="{{ $car->images[0]->url }}" class="img-fluid" style="max-width:100px;">
                                <p class="text-muted text-center">{{ count($car->images) }} зураг</p>
                            @endif
                        </td>
                        <td>{{ $car->name }}</td>
                        <td>
                            @if (!empty($car->group->name))
                                {{ $car->group->name }}
                            @endif
                        </td>
                        <td>
                            @if (!empty($car->mark->name))
                                {{ $car->mark->name }}
                            @endif
                        </td>
                        <td>
                            @if (!empty($car->model->name))
                                {{ $car->model->name }}
                            @endif
                        </td>
                        <td>{{ $car->import_year }} он, {{ $car->import_month }} сар</td>
                        <td>{{ $car->made_in_year }}</td>
                        <td>{{ number_format($car->price, 0) }}</td>
                        <td>{{ $car->seller }}</td>
                        <td>
                            {{-- @can("cars-list")
                                <a class="btn btn-info" href="{{ route("cars.show", $car->id) }}">Show</a>
                            @endcan  --}}
                            @can("cars-edit")
                                <a class="btn btn-primary" href="{{ route("cars.edit", $car->id) }}">Edit</a>
                            @endcan
                            @can("cars-delete")
                                <confirm-delete
                                    :data-id="{{ json_encode($car->id) }}" 
                                    :data-title="{{ json_encode($car->name) }}" 
                                    :data-url="{{ json_encode('/cars/' . $car->id) }}" 
                                    data-redirect-url="/cars">
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