<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Helpers\Status;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\ResetPassworkRequest;
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
                $message = 'The emails has already been taken.';
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
            $result = $this->accountService->userProfile();
            return ResponseHelper::send($result['data']);
        }

        public function getUserByQuery(Request $request)
        {
            $query = $request->only(['display_name', 'id', 'role_id']);
            return ResponseHelper::send($this->accountService->getUserByQuery($query));
        }

        public function update(Request $request)
        {
            $data = $request->except('password');
            $id = auth()->user()['id'];
            $result = $this->accountService->update($data, $id);
            return ResponseHelper::send($result['data']);
        }

        public function resetPassword(ResetPassworkRequest $request)
        {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $id = auth()->user()['id'];
            $result = $this->accountService->changePassword($data, $id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                $message = 'Password is incorrect.';
                return ResponseHelper::send([], Status::NOT_GOOD, HttpCode::BAD_REQUEST, $message);
            }
            return ResponseHelper::send($result['data']);
        }
    }
