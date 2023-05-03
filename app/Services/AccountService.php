<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\AccountRepository;
    use App\Repositories\AddressRepository;
    use App\Repositories\InformationRepository;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class AccountService
    {
        protected $accountRepository;
        protected $addressRepository;
        protected $informationRepository;

        /**
         * @param $accountRepository
         */
        public function __construct(
            AccountRepository $accountRepository,
            AddressRepository $addressRepository,
            InformationRepository $informationRepository
        ) {
            $this->accountRepository = $accountRepository;
            $this->addressRepository = $addressRepository;
            $this->informationRepository = $informationRepository;
        }

        public function checkAccountIsExist($id)
        {
            return !is_null($this->accountRepository->findWhere(['id' => $id])->first());
        }

        public function register($data)
        {
            try {
                DB::beginTransaction();
                $address = $this->addressRepository->create([
                    'street' => $data['street'],
                    'ward' => $data['ward'],
                    'district' => $data['district'],
                    'city' => $data['city']
                ]);
                $information = $this->informationRepository->create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'gender' => $data['gender'],
                    'phone' => $data['phone'],
                    'address_id' => $address['id'],
                ]);
                $result = $this->accountRepository->create([
                    'display_name' => $data['display_name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'role_id' => $data['role_id'],
                    'information_id' => $information['id']
                ]);
                DB::commit();
                return DataReturn::Result($result);
            } catch (ModelNotFoundException $e) {
                Log::error($e);
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
                return DataReturn::Result(status: HttpCode::UNKNOWN_ERROR);
            }
        }

        public function login($request)
        {
            if (!$token = auth()->attempt($request)) {
                return [
                    'data' => 'Unauthorized',
                    'status' => HttpCode::BAD_REQUEST
                ];
            }
            return $this->createNewToken($token);
        }

        protected function createNewToken($token)
        {
            $results["data"] = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'account' => auth()->user()
            ];
            $results["status"] = HttpCode::CREATED;
            return $results;
        }

        public function logout()
        {
            auth()->logout();
            return ['message' => 'User successfully signed out'];
        }

        public function refresh()
        {
            return $this->createNewToken(auth()->refresh());
        }

    }
