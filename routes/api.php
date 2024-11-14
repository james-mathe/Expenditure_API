<?php

use App\Http\Controllers\AnalyseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\taskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource("/expenditure",ExpenditureController::class);
Route::apiResource("/category",categoryController::class);
Route::apiResource("/tasks",taskController::class);

// fro authentication

Route::post("Auth/register", [AuthController::class,"register"]);
Route::post("Auth/login", [AuthController::class,"login"]);
Route::post("Auth/logout", [AuthController::class,"logout"])->middleware('auth:sanctum');

Route::get("Spent/Monthly", [AnalyseController::class,"Monthly"]);
Route::get("Spent/Daily", [AnalyseController::class,"Daily"]);
Route::get("Spent/Category", [AnalyseController::class,"Category"]);
// Route::get('exp', [AnalyseController::class,'Mo']);

// for the paginate part
Route::get("paginate/expenditure",[ExpenditureController::class,"getAllPaginate"]);
Route::get("paginate/category",[categoryController::class,"getAllPaginate"]);
Route::get("paginate/task",[taskController::class,"getAllPaginate"]);