<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Checklist\ChecklistController;
use App\Http\Controllers\API\Item\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::resource('checklist', ChecklistController::class);

    Route::get('checklist/{checklistId}/item', [ItemController::class, 'index']);
    Route::post('checklist/{checklistId}/item', [ItemController::class, 'store']);
    Route::get('checklist/{checklistId}/item/{itemId}', [ItemController::class, 'show']);
    Route::put('checklist/{checklistId}/item/{itemId}', [ItemController::class, 'update']);
    Route::delete('checklist/{checklistId}/item/{itemId}', [ItemController::class, 'destroy']);
    Route::put('checklist/{checklistId}/item/rename/{itemId}', [ItemController::class, 'rename']);
});
