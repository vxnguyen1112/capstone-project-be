<?php

    namespace App\Http\Controllers\api;

    use App\Exceptions\FreetimeException;
    use App\Helpers\CommonResponse;
    use App\Helpers\HttpCode;
    use App\Helpers\ResponseHelper;
    use App\Helpers\Status;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreFreeTimeRequest;
    use App\Http\Requests\StoreRoleRequest;
    use App\Services\FreeTimeService;
    use App\Services\RoleService;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FreeTimeController extends Controller
    {
        protected $freeTimeService;

        public function __construct(FreeTimeService $freeTimeService)
        {
            $this->freeTimeService = $freeTimeService;
        }

        public function store(StoreFreeTimeRequest $request)
        {
            try {
                DB::beginTransaction();
                $result = $this->freeTimeService->store($request->all());
                DB::commit();
                return ResponseHelper::send($result['data'], statusCode: HttpCode::CREATED);
            } catch (ModelNotFoundException $e) {
                Log::error($e);
                return CommonResponse::notFoundResponse();
            } catch (FreetimeException $e) {
                return ResponseHelper::send([], Status::NOT_GOOD, HttpCode::BAD_REQUEST, $e->message());
            } catch (\Exception $e) {
                error_log($e);
                DB::rollBack();
                Log::error($e);
                return CommonResponse::unknownResponse();
            }
        }

        public function getAllRole()
        {
            $result = $this->freeTimeService->getAllFreeTime();
            return ResponseHelper::send($result['data']);
        }

        public function getRoleById($id)
        {
            $result = $this->freeTimeService->getRoleById($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function update(Request $request, $id)
        {
            $result = $this->freeTimeService->update($request->all(), $id);
            if ($$result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return ResponseHelper::send($result['data']);
        }

        public function destroy($id)
        {
            $result = $this->freeTimeService->delete($id);
            if ($result['status'] === HttpCode::NOT_FOUND) {
                return CommonResponse::notFoundResponse();
            }
            return CommonResponse::deleteSuccessfullyResponse();
        }
    }
