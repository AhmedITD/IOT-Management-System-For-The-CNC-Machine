<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authmanger;
use App\Http\Controllers\gcodeController;
Route::get('/', [Authmanger::class, 'login'])->name(name: 'login');
Route::post('/', [Authmanger::class, 'loginPost'])->name(name: 'login.post');

Route::get('gcodes/logout', [Authmanger::class, 'logout'])->name(name: 'logout');

Route::group(['middleware' => 'auth'],function()
{
    Route::get('/register', [Authmanger::class, 'register'])->name(name: 'register');
    Route::post('/register', [Authmanger::class, 'registerPost'])->name(name: 'register.post');
    
    Route::get('/gcodes', [gcodeController::class, 'index'])->name(name: 'gcodes');

    Route::get('/gcodes/create', [gcodeController::class, 'create'])->name(name: 'gcodes.create');
    Route::post('/gcodes/create', [gcodeController::class, 'createPost'])->name(name: 'gcodes.create.post');

    Route::get('/gcodes/{gcode}/edite', [gcodeController::class, 'edite'])->name(name: 'gcodes.edite');
    Route::put('/gcodes/{gcode}/update', [gcodeController::class, 'update'])->name(name: 'gcodes.update');
    
    Route::delete('/gcodes/{gcode}/delete', [gcodeController::class, 'delete'])->name(name: 'gcodes.delete');

    Route::get('/gcodes/{gcode}/ask', [gcodeController::class, 'ask'])->name(name: 'gcodes.ask');
    Route::post('/gcodes/{gcode}/ask', [gcodeController::class, 'askPost'])->name(name: 'gcodes.askPost');

    Route::get('/gcodes/RealTime', [gcodeController::class, 'RealTime'])->name(name: 'RealTime');

    Route::get('/gcodes/Settings', [gcodeController::class, 'Settings'])->name(name: 'Settings');
    Route::post('/gcodes/Settings', [gcodeController::class, 'SettingsPost'])->name(name: 'Settings.post');
});
