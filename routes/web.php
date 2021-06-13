<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SettingController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\InfoCategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyCategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NoteCategoryController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarCategoryController;

Route::get("/", function () {
    return view("welcome");
});

Auth::routes(["register" => false]);

Route::get("/home", [App\Http\Controllers\HomeController::class, "index"])->name("home");

Route::group(["middleware" => ["auth"]], function() {
    Route::get("/settings", [SettingController::class, "index"])->name("settings");
    Route::post("/settings", [SettingController::class, "store"])->name("settings.store");
    Route::post("/settings/slider-delete", [SettingController::class, "delete_slider"])->name("settings.slider.delete");

    Route::resource("roles", RoleController::class);
    Route::resource("permissions", PermissionController::class);
    Route::resource("users", UserController::class);
    
    Route::resource("infos", InfoController::class);
    Route::resource("info-categories", InfoCategoryController::class);

    Route::resource("companies", CompanyController::class);
    Route::resource("company-categories", CompanyCategoryController::class);
    
    Route::resource("notes", NoteController::class);
    Route::resource("note-categories", NoteCategoryController::class);

    Route::resource("cars", CarController::class);
    Route::post("cars/image-delete/{id}", [CarController::class, "delete_image"])->name("cars.image.delete");
    Route::resource("car-categories", CarCategoryController::class);
});