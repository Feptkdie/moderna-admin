@extends('layouts.app')
@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="/home">Нүүр</a></li>
           <li class="breadcrumb-item"><a href="{{ route("cars.index") }}">Машинууд</a></li>
           <li class="breadcrumb-item active" aria-current="page">Машин нэмэх</li>
        </ol>
     </nav>

    <h3>Машин бүртгэх</h3>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route("cars.store") }}" method="POST" enctype="multipart/form-data">
        @csrf

        <car-multiple-upload data-mode="add"></car-multiple-upload>
        <car-category-filters data-mode="add" :data-categories="{{ json_encode($categories) }}"></car-category-filters>

        <div class="form-group">
            <label for="name">Нэр:</label>
            <input type="text" name="name" class="form-control" id="name">
        </div>

        <div class="form-group">
            <label for="type">Төрөл:</label>
            <select class="form-control" name="type">
                <option value="">-- Төрөл сонгох --</option>
                <option value="suudliin">Суудлын</option>
                <option value="gerbul">Гэр бүлийн</option>
                <option value="jeep">Жийп</option>
                <option value="minijeep">Мини жийп</option>
                <option value="pikap">Пикап</option>
                <option value="sport">Спорт</option>
            </select>
        </div>

        <div class="form-group">
            <label for="import_year">Орж ирсэн он:</label>
            <input type="number" name="import_year" class="form-control" id="import_year">
        </div>

        <div class="form-group">
            <label for="import_month">Орж ирсэн сар:</label>
            <select class="form-control" id="import_month" name="import_month">
                @for ($i=1; $i<=12; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="made_in_year">Үйлдвэрлэсэн он:</label>
            <input type="number" name="made_in_year" class="form-control" id="made_in_year">
        </div>

        <div class="form-group">
            <label for="driver_hand">Жолооны хүрд:</label>
            <select class="form-control" id="driver_hand" name="driver_hand">
                <option value="left">Зөв</option>
                <option value="right">Буруу</option>
            </select>
        </div>

        <div class="form-group">
            <label for="engine_capacity">Хөдөлгүүрийн багтаамж:</label>
            <input type="number" name="engine_capacity" class="form-control" id="engine_capacity" step="any">
        </div>

        <div class="form-group">
            <label for="hutlugch">Хөтлөгч:</label>
            <select class="form-control" id="hutlugch" name="hutlugch">
                <option value="urdaa">Урдаа</option>
                <option value="hoinoo">Хойноо</option>
                <option value="buh_duguin">Бүх дууйн</option>
            </select>
        </div>

        <div class="form-group">
            <label for="running_km">Гүйлт</label>
            <input type="number" name="running_km" class="form-control" id="running_km">
        </div>

        <div class="form-group">
            <label for="hrop">Хроп:</label>
            <select class="form-control" id="hrop" name="hrop">
                <option value="automat">Автомат</option>
                <option value="mechanic">Механик</option>
            </select>
        </div>

        <div class="form-group">
            <label for="fuel">Моторын төрөл:</label>
            <select class="form-control" id="fuel" name="fuel">
                <option value="benzine">Бензин</option>
                <option value="diesel">Дизель</option>
                <option value="gas">Газ</option>
                <option value="hybrid">Хайбрид</option>
                <option value="electric">Цахилгаан</option>
            </select>
        </div>

        <div class="form-group">
            <label for="decription">Тайлбар</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Үнэ</label>
            <input type="number" name="price" class="form-control" id="price">
        </div>

        <div class="form-group">
            <label for="phone">Утас</label>
            <input type="text" name="phone" class="form-control" id="phone">
        </div>

        <div class="form-group">
            <label for="seller">Борлуулагч</label>
            <input type="text" name="seller" class="form-control" id="seller">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection