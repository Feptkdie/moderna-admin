<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;

Route::group(["middleware" => "auth:api"], function () {
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::post("/refresh", [AuthController::class, "refresh"]);
    Route::get("/me", [AuthController::class, "me"]);
    Route::post("/change-password", [AuthController::class, "changePassword"]);
    Route::post("/update-user", [AuthController::class, "updateUser"]);
    Route::post("/profile-addcar", [AuthController::class, "addCar"]);
    Route::put("/profile-editcar/{id}", [AuthController::class, "editCar"]);
    Route::delete("/profile-deletecar/{id}", [AuthController::class, "deleteCar"]);

    Route::post("/profile-addpart", [AuthController::class, "addPart"]);
    Route::post("/profile-editpart/{id}", [AuthController::class, "editPart"]);
    Route::delete("/profile-deletepart/{id}", [AuthController::class, "deletePart"]);
});

Route::group(["middleware" => "guest:api"], function () {
    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);
    
    // Route::post("/password/email", "Api\ForgotPasswordController@sendResetLinkEmail");
    // Route::post("/password/reset", "Api\ResetPasswordController@reset");
    
    Route::get("/get-data", [ApiController::class, "get_data"]);
    Route::get("/company/categories", [ApiController::class, "categories_with_company"]);
    Route::get("/infos", [ApiController::class, "get_all_infos"]);
    Route::get("/sos", [ApiController::class, "get_all_sos"]);
    Route::get("/cars", [ApiController::class, "get_all_cars"]);
});