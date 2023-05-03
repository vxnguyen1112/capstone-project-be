<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Helpers\Status;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\StoreRegisterRequest;
    use App\Services\AccountService;
    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;

    class AuthController extends Controller
    {
        protected $accountService;

        public function __construct(AccountService $accountService)
        {
            $this->accountService = $accountService;
        }

        public function register(StoreRegisterRequest $request)
        {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $result = $this->accountService->register($input);
            if ($result['status'] === HttpCode::BAD_REQUEST) {
                $message = 'The email has already been taken.';
                return ResponseHelper::send([], Status::NOT_GOOD, HttpCode::BAD_REQUEST, $message);
            }
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function login(LoginRequest $request)
        {
            $result = $this->accountService->login($request->all());
            if ($result['status'] === HttpCode::CREATED) {
                return ResponseHelper::send($result["data"], statusCode: HttpCode::CREATED);
            }
            return ResponseHelper::send([], Status::NOT_GOOD, HttpCode::BAD_REQUEST, $result["data"]);
        }

        public function logout()
        {
            $result = $this->accountService->logout();
            return ResponseHelper::send($result['data']);
        }

        public function refresh()
        {
            $result = $this->accountService->refresh();
            return ResponseHelper::send($result["data"]);
        }

        public function userProfile()
        {
            return ResponseHelper::send(auth()->user());
        }
    }
