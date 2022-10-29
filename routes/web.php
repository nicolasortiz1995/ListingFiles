<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::guest()){
        return redirect()->route('login');
    }else{
        return redirect()->route('dashboard');
    }
});

//auth
Route::prefix('auth')->group(function(){  

    Route::get('login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'loginVerify']);

    Route::get('register',[AuthController::class,'register']);
    Route::post('register',[AuthController::class,'registerVerify']);

    Route::post('signOut',[AuthController::class,'signOut'])->name('signOut');
    Route::post('changePasswordLogin',[AuthController::class,'changePasswordLogin'])->name('changePasswordLogin');
});


// Protected

Route::middleware('auth')->group(function () {
    
    Route::get('dashboard',function(){
        return view('dashboard');
    })->name('dashboard');

    /*Route::get('users',function(){
        return view('users');
    })->name('users');*/

    Route::get('users', [UsersController::class, 'index'])->name('users');

    Route::prefix('users')->group(function(){  
        Route::get('/create', [UsersController::class, 'create'])->name('users.create');
        Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::get('/show/{id}', [UsersController::class, 'show'])->name('users.show');
        Route::put('/update/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/destroy/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::post('/store', [UsersController::class, 'store'])->name('users.store');
    });
    
    Route::get('loadingFiles', [UsersController::class, 'loadingFiles'])->name('loadingFiles');
    Route::get('searchFiles', [UsersController::class, 'searchFiles'])->name('searchFiles');
    Route::get('listDirFiles', [UsersController::class, 'listDirFiles'])->name('listDirFiles');
    Route::post('uploadfiles', [UsersController::class, 'uploadfiles'])->name('uploadfiles');
    Route::post('deletefiles', [UsersController::class, 'deletefiles'])->name('deletefiles');

});

