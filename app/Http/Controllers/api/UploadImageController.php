<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\UploadImageRequest;
    use App\Models\Account;
    use App\Services\AccountService;
    use Cloudinary\Api\Upload\UploadApi;
    use Illuminate\Http\Request;
    use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
    use Cloudinary\Configuration\Configuration;
    use Illuminate\Support\Facades\Log;

    class UploadImageController extends Controller
    {
        protected $accountService;

        public function __construct(AccountService $accountService)
        {
            $this->accountService = $accountService;
        }

        public function upload($image)
        {
            $uploadedFile = Cloudinary::upload($image->getRealPath());
            $public_id = $uploadedFile->getPublicId();
            $result['avatar_url'] = $uploadedFile->getSecurePath($public_id);
            return $result;
        }

        public function uploadToAccountImage(UploadImageRequest $request)
        {
            $account_id = auth()->user()['id'];
            $image = $request->file('image');
            $data = $this->upload($image);
            $result = $this->accountService->update($data, $account_id);
            return ResponseHelper::send($result);
        }

    }
