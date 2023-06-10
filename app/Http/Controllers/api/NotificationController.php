<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Helpers\Status;
    use App\Http\Controllers\Controller;
    use App\Services\NotificationService;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;
    use PhpParser\Node\Stmt\Return_;
    use Tymon\JWTAuth\Facades\JWTAuth;
    use Tymon\JWTAuth\Facades\JWTFactory;
    use Illuminate\Support\Facades\Crypt;

    class NotificationController extends Controller
    {

        protected $notificationService;


        public function __construct(

            NotificationService $notificationService
        ) {

            $this->notificationService = $notificationService;
        }

        public function getNotification()
        {
            return ResponseHelper::send($this->notificationService->getNotification());
        }

        public function checkNotification()
        {
            return ResponseHelper::send($this->notificationService->checkNotification());
        }

    }
