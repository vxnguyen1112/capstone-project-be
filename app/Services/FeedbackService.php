<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\BlogRepository;
    use App\Repositories\FeedbackRepository;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;

    class FeedbackService
    {
        protected $feedbackRepository;


        /**
         * @param $feedbackRepository
         */


        public function __construct(FeedbackRepository $feedbackRepository)
        {
            $this->feedbackRepository = $feedbackRepository;
        }

        public function store($data)
        {
            return DataReturn::Result($this->feedbackRepository->create($data));
        }

        public function getFeedbackByDoctor($id)
        {
            return DataReturn::Result($this->feedbackRepository->getFeedbackByDoctor($id));
        }

        public function getFeedbackById($id)
        {
            if (!$this->checkFeedbackIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->feedbackRepository->with(['account'])->findWhere(['id' => $id]));
        }

        public function checkFeedbackIsExist($id)
        {
            return !is_null($this->feedbackRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkFeedbackIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->feedbackRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkFeedbackIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->feedbackRepository->delete($id));
        }
    }
