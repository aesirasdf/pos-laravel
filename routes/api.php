<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);
Route::get("/user", [AuthController::class, "checkToken"])->middleware("auth:sanctum");
Route::delete("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");



Route::group(["middleware" => "auth:sanctum", 'prefix' => "categories"], function (){
    Route::get("/", [CategoryController::class,"index"]);
    Route::get("/{category}", [CategoryController::class,"show"]);
    Route::post("/", [CategoryController::class,"store"]);
    Route::patch("/{category}", [CategoryController::class,"update"]);
    Route::delete("/{category}", [CategoryController::class,"destroy"]);
});
Route::group(["middleware" => "auth:sanctum", 'prefix' => "products"], function (){
    Route::get("/", [ProductController::class,"index"]);
    Route::get("/{product}", [ProductController::class,"show"]);
    Route::post("/", [ProductController::class,"store"]);
    Route::patch("/{product}", [ProductController::class,"update"]);
    Route::delete("/{product}", [ProductController::class,"destroy"]);
});

Route::group(["middleware" => "auth:sanctum", 'prefix' => "transactions"], function (){
    Route::get("/", [TransactionController::class,"index"]);
    Route::get("/{transaction}", [TransactionController::class,"show"]);
    Route::post("/", [TransactionController::class,"store"]);
    Route::patch("/{transaction}", [TransactionController::class,"update"]);
    Route::delete("/{transaction}", [TransactionController::class,"destroy"]);
});