<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\api\RoleController;
    use App\Http\Controllers\api\AuthController;
    use App\Http\Controllers\api\DoctorController;
    use App\Http\Controllers\api\FreeTimeController;


    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */
    Route::group([
        'prefix' => "auth"
    ], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });
    Route::group([
        'middleware' => 'auth'
    ], function () {
        Route::group(
            [
                'prefix' => "auth"
            ],
            function () {
                Route::post('/logout', [AuthController::class, 'logout']);
                Route::post('/refresh', [AuthController::class, 'refresh']);
                Route::get('/user-profile', [AuthController::class, 'userProfile']);
                Route::post('/change-pass', [AuthController::class, 'changePassWord']);
            }
        );
    });
    Route::get('/role', [RoleController::class, 'getAllRole']);
    Route::get('/role/{id}', [RoleController::class, 'getRoleById']);
    Route::post('/role', [RoleController::class, 'store']);
    Route::put('/role/{id}/', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);

    Route::get('/doctor', [DoctorController::class, 'getAllDoctor']);
    Route::get('/doctor/freetime', [DoctorController::class, 'getFreeTimeAllDoctor']);
    Route::get('/doctor/{id}', [DoctorController::class, 'getDoctorById']);
    Route::get('/doctor/{id}/freetime', [DoctorController::class, 'getFreeTimeByDoctorId']);
    Route::post('/doctor', [DoctorController::class, 'store']);
    Route::put('/doctor/{id}/', [DoctorController::class, 'update']);
    Route::delete('/doctor/{id}', [DoctorController::class, 'destroy']);

    Route::get('/freetime/{id}', [FreeTimeController::class, 'getDoctorById']);
    Route::post('/freetime', [FreeTimeController::class, 'store']);
    Route::put('/freetime/{id}/', [FreeTimeController::class, 'update']);
    Route::delete('/freetime/{id}', [FreeTimeController::class, 'destroy']);
