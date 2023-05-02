<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\RoleService;
    use Illuminate\Http\Request;

    class RoleController extends Controller
    {
        protected $roleService;

        public function __construct(RoleService $roleService)
        {
            $this->roleService = $roleService;
        }

        public function store(StoreRoleRequest $request)
        {
            $result = $this->roleService->store($request->all());
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }

        public function getAllRole()
        {
            $result = $this->roleService->getAllRole();
            return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
        }
        public function getRoleById($id)
        {
            $result = $this->roleService->getRoleById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }
        public function update(Request $request, $id)
        {
            $result = $this->roleService->update($request->all(), $id);
            if ($$result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->roleService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
