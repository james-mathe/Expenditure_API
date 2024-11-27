<?php

use App\Http\Controllers\AnalyseController;
use App\Http\Controllers\AnalyseEntryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\taskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource("/Expenditure",ExpenditureController::class);
Route::apiResource("/Category",categoryController::class);
Route::apiResource("/Tasks",taskController::class);
Route::apiResource("/Entry",EntriesController::class);
Route::apiResource("/Log",loginController::class);

// fro authentication

Route::post("Auth/Register", [AuthController::class,"register"]);
Route::post("Auth/Login", [AuthController::class,"login"]);
Route::post("Auth/Logout", [AuthController::class,"logout"])->middleware('auth:sanctum');

Route::get("Spent/monthly", [AnalyseController::class,"Monthly"]);
Route::get("Spent/daily", [AnalyseController::class,"Daily"]);
Route::get("Spent/category", [AnalyseController::class,"Category"]);
Route::get("entries/monthly", [AnalyseEntryController::class,"Monthly"]);
Route::get("entries/daily", [AnalyseEntryController::class,"Daily"]);
Route::get("entries/category", [AnalyseEntryController::class,"Category"]);
Route::get("Login", [loginController::class,"getElementByuid"]);
Route::get("expense/byCategory", [ExpenditureController::class,"getExpenditureByCategory"]);
Route::get("entries/byCategory", [EntriesController::class,"getEntriesByCategory"]);
// Route::get('exp', [AnalyseController::class,'Mo']);

// for the paginate part

Route::get("paginate/Expenditure",[ExpenditureController::class,"getAllPaginate"]);
Route::get("paginate/Category",[categoryController::class,"getAllPaginate"]);
Route::get("paginate/Task",[taskController::class,"getAllPaginate"]);
Route::get("paginate/Entry",[EntriesController::class,"getAllPaginate"]);