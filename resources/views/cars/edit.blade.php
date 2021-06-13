@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Нүүр</a></li>
           <li class="breadcrumb-item"><a href="{{ route("cars.index") }}">Машинууд</a></li>
           <li class="breadcrumb-item active" aria-current="page">Машин засах</li>
        </ol>
     </nav>

    <h3>Машин засах</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route("cars.update", $car->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("PUT")

        <car-multiple-upload data-mode="edit" data-id="{{ json_encode($car->id) }}" :data-images="{{ json_encode($car->images) }}"></car-multiple-upload>
        <car-category-filters data-mode="edit" :data-car="{{ json_encode($car) }}" :data-categories="{{ json_encode($categories) }}"></car-category-filters>

        <div class="form-group">
            <label for="name">Нэр:</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $car->name }}">
        </div>

        <div class="form-group">
            <label for="type">Төрөл:</label>
            <select class="form-control" name="type">
                <option value="">-- Төрөл сонгох --</option>
                <option value="suudliin" @if($car->type == "suudliin") selected @endif>Суудлын</option>
                <option value="gerbul" @if($car->type == "gerbul") selected @endif>Гэр бүлийн</option>
                <option value="jeep" @if($car->type == "jeep") selected @endif>Жийп</option>
                <option value="minijeep" @if($car->type == "minijeep") selected @endif>Мини жийп</option>
                <option value="pikap" @if($car->type == "pikap") selected @endif>Пикап</option>
                <option value="sport" @if($car->type == "sport") selected @endif>Спорт</option>
            </select>
        </div>

        <div class="form-group">
            <label for="import_year">Орж ирсэн он:</label>
            <input type="number" name="import_year" class="form-control" id="import_year" value="{{ $car->import_year }}">
        </div>

        <div class="form-group">
            <label for="import_month">Орж ирсэн сар:</label>
            <select class="form-control" id="import_month" name="import_month">
                @for ($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" @if($car->import_month == $i) selected @endif>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="made_in_year">Үйлдвэрлэсэн он:</label>
            <input type="number" name="made_in_year" class="form-control" id="made_in_year" value="{{ $car->made_in_year }}">
        </div>

        <div class="form-group">
            <label for="driver_hand">Жолооны хүрд:</label>
            <select class="form-control" id="driver_hand" name="driver_hand">
                <option value="left" @if($car->driver_hand == "left") selected @endif>Зөв</option>
                <option value="right" @if($car->driver_hand == "right") selected @endif>Буруу</option>
            </select>
        </div>

        <div class="form-group">
            <label for="engine_capacity">Хөдөлгүүрийн багтаамж:</label>
            <input type="number" name="engine_capacity" class="form-control" id="engine_capacity" step="any" value="{{ $car->engine_capacity }}">
        </div>

        <div class="form-group">
            <label for="hutlugch">Хөтлөгч:</label>
            <select class="form-control" id="hutlugch" name="hutlugch">
                <option value="urdaa" @if($car->hutlugch == "urdaa") selected @endif>Урдаа</option>
                <option value="hoinoo" @if($car->hutlugch == "hoinoo") selected @endif>Хойноо</option>
                <option value="buh_duguin" @if($car->hutlugch == "buh_duguin") selected @endif>Бүх дууйн</option>
            </select>
        </div>

        <div class="form-group">
            <label for="running_km">Гүйлт</label>
            <input type="number" name="running_km" class="form-control" id="running_km" value="{{ $car->running_km }}">
        </div>

        <div class="form-group">
            <label for="hrop">Хроп:</label>
            <select class="form-control" id="hrop" name="hrop">
                <option value="automat" @if($car->hrop == "automat") selected @endif>Автомат</option>
                <option value="mechanic" @if($car->hrop == "mechanic") selected @endif>Механик</option>
            </select>
        </div>

        <div class="form-group">
            <label for="fuel">Моторын төрөл:</label>
            <select class="form-control" id="fuel" name="fuel">
                <option value="benzine" @if($car->fuel == "benzine") selected @endif>Бензин</option>
                <option value="diesel" @if($car->fuel == "diesel") selected @endif>Дизель</option>
                <option value="gas" @if($car->fuel == "gas") selected @endif>Газ</option>
                <option value="hybrid" @if($car->fuel == "hybrid") selected @endif>Хайбрид</option>
                <option value="electric" @if($car->fuel == "electric") selected @endif>Цахилгаан</option>
            </select>
        </div>

        <div class="form-group">
            <label for="decription">Тайлбар</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{ $car->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Үнэ</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ $car->price }}">
        </div>

        <div class="form-group">
            <label for="phone">Утас</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ $car->phone }}">
        </div>

        <div class="form-group">
            <label for="seller">Борлуулагч</label>
            <input type="text" name="seller" class="form-control" id="seller" value="{{ $car->seller }}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection