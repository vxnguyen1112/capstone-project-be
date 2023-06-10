<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\api\RoleController;
    use App\Http\Controllers\api\AuthController;
    use App\Http\Controllers\api\DoctorController;
    use App\Http\Controllers\api\FreeTimeController;
    use App\Http\Controllers\api\AppointmentController;
    use App\Http\Controllers\api\MedicalRecordController;
    use App\Http\Controllers\api\MedicationController;
    use App\Http\Controllers\api\MessageController;
    use App\Http\Controllers\api\UploadImageController;
    use App\Http\Controllers\api\BlogController;
    use App\Http\Controllers\api\CommentController;
    use App\Http\Controllers\api\FeedbackController;
    use App\Http\Controllers\api\NotificationController;



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
                Route::get('/user', [AuthController::class, 'getUserByQuery']);
                Route::put('/user', [AuthController::class, 'update']);
                Route::post('/change-pass', [AuthController::class, 'changePassWord']);
                Route::post('/avatar', [UploadImageController::class, 'uploadToAccountImage']);
            }
        );

        Route::get('/message/{id}', [MessageController::class, 'getMessageByIdAccount']);
        Route::get('/account/{id}/message', [MessageController::class, 'getAllConversation']);
        Route::post('/message', [MessageController::class, 'store']);
        Route::put('/message/{id}/', [MessageController::class, 'update']);
        Route::delete('/message/{id}', [MessageController::class, 'destroy']);

        Route::get('/notification', [NotificationController::class, 'getNotification']);
        Route::get('/notification/check', [NotificationController::class, 'checkNotification']);
    });
    Route::get('/role', [RoleController::class, 'getAllRole']);
    Route::get('/role/{id}', [RoleController::class, 'getRoleById']);
    Route::post('/role', [RoleController::class, 'store']);
    Route::put('/role/{id}/', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);

    Route::get('/doctor', [DoctorController::class, 'getAllDoctor']);
    Route::get('/doctor/freetime', [DoctorController::class, 'getFreeTimeAllDoctor']);
    Route::get('/doctor/appointment', [AppointmentController::class, 'getAppointmentAllDoctor']);
    Route::get('/doctor/medicalrecord', [MedicalRecordController::class, 'getMedicalRecordAllDoctor']);
    Route::get('/doctor/{id}', [DoctorController::class, 'getDoctorById']);
    Route::get('/doctor/{id}/freetime', [DoctorController::class, 'getFreeTimeByDoctorId']);
    Route::get('/doctor/{id}/patient', [DoctorController::class, 'getPatientOfDoctor']);
    Route::get('/doctor/{id}/feedback', [FeedbackController::class, 'getFeedbackByDoctor']);
    Route::post('/doctor', [DoctorController::class, 'store']);
    Route::put('/doctor/{id}/', [DoctorController::class, 'update']);
    Route::delete('/doctor/{id}', [DoctorController::class, 'destroy']);

    Route::get('/freetime/{id}', [FreeTimeController::class, 'getDoctorById']);
    Route::post('/freetime', [FreeTimeController::class, 'store']);
    Route::put('/freetime/{id}/', [FreeTimeController::class, 'update']);
    Route::delete('/freetime/{id}', [FreeTimeController::class, 'destroy']);

    Route::get('/appointment', [AppointmentController::class, 'getAllAppointment']);
    Route::get('/appointment/{id}', [AppointmentController::class, 'getAppointmentById']);
    Route::get('/doctor/{id}/appointment', [AppointmentController::class, 'getAppointmentByDoctorId']);
    Route::get('/patient/{id}/appointment', [AppointmentController::class, 'getAppointmentByPatientId']);
    Route::get('/patient/appointment', [AppointmentController::class, 'getAppointmentAllPatient']);
    Route::get('/appointment/{id}', [AppointmentController::class, 'getAppointmentById']);
    Route::post('/appointment', [AppointmentController::class, 'store']);
    Route::put('/appointment/{id}/', [AppointmentController::class, 'update']);
    Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy']);

    Route::get('/medicalrecord/{id}', [MedicalRecordController::class, 'getMedicalRecordById']);
    Route::get('/doctor/{id}/medicalrecord', [MedicalRecordController::class, 'getMedicalRecordByDoctorId']);
    Route::get('/patient/{id}/medicalrecord', [MedicalRecordController::class, 'getMedicalRecordByPatientId']);
    Route::get('/patient/medicalrecord', [MedicalRecordController::class, 'getMedicalRecordByPatientId']);
    Route::get('/medicalrecord/{id}', [MedicalRecordController::class, 'getMedicalRecordById']);
    Route::post('/medicalrecord', [MedicalRecordController::class, 'store']);
    Route::put('/medicalrecord/{id}/', [MedicalRecordController::class, 'update']);
    Route::delete('/medicalrecord/{id}', [MedicalRecordController::class, 'destroy']);

    Route::get('/medication/{id}', [MedicationController::class, 'getMedicationById']);
    Route::get('/medicalrecord/{id}/medication', [MedicationController::class, 'getMedicationByMedicalRecordId']);
    Route::post('/medication', [MedicationController::class, 'store']);
    Route::put('/medication/{id}/', [MedicationController::class, 'update']);
    Route::delete('/medication/{id}', [MedicationController::class, 'destroy']);

    Route::get('/blog', [BlogController::class, 'getAllBlog']);
    Route::get('/blog/{id}', [BlogController::class, 'getBlogById']);
    Route::get('/blog/{id}/comment', [CommentController::class, 'getCommentByBlog']);
    Route::post('/blog', [UploadImageController::class, 'uploadToBlog']);
    Route::put('/blog/{id}/', [BlogController::class, 'update']);
    Route::delete('/blog/{id}', [BlogController::class, 'destroy']);

    Route::get('/comment/{id}', [CommentController::class, 'getCommentById']);
    Route::post('/comment', [CommentController::class, 'store']);
    Route::put('/comment/{id}/', [CommentController::class, 'update']);
    Route::delete('/comment/{id}', [CommentController::class, 'destroy']);

    Route::get('/feedback/{id}', [FeedbackController::class, 'getFeedbackById']);
    Route::post('/feedback', [FeedbackController::class, 'store']);
    Route::put('/feedback/{id}/', [FeedbackController::class, 'update']);
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']);
