<?php

    namespace App\Http\Controllers\api;

    use App\Helpers\CommonResponse;
    use App\Helpers\ResponseHelper;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreBlogRequest;
    use App\Http\Requests\UploadImageRequest;
    use App\Models\Account;
    use App\Services\AccountService;
    use App\Services\BlogService;
    use Cloudinary\Api\Upload\UploadApi;
    use Illuminate\Http\Request;
    use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
    use Cloudinary\Configuration\Configuration;
    use Illuminate\Support\Facades\Log;

    class UploadImageController extends Controller
    {
        protected $accountService;
        protected $blogService;


        public function __construct(AccountService $accountService, BlogService $blogService)
        {
            $this->accountService = $accountService;
            $this->blogService = $blogService;
        }

        public function upload($image)
        {
            $uploadedFile = Cloudinary::upload($image->getRealPath());
            $public_id = $uploadedFile->getPublicId();
            $result['url'] = $uploadedFile->getSecurePath($public_id);
            return $result;
        }

        public function uploadToAccountImage(UploadImageRequest $request)
        {
            $account_id = auth()->user()['id'];
            $image = $request->file('image');
            $data['avatar_url'] = $this->upload($image)['url'];
            $result = $this->accountService->update($data, $account_id);
            return ResponseHelper::send($result);
        }

        public function uploadToBlog(StoreBlogRequest $request)
        {
            $data = $request->all();
            if( $request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = $this->upload($image)['url'];
            }
            $result = $this->blogService->store($data);
            return ResponseHelper::send($result);
        }


    }
