<?php

    namespace App\Services;

    use App\Exceptions\FreetimeException;
    use App\Helpers\DataReturn;
    use App\Helpers\FreeTimeMessage;
    use App\Helpers\HttpCode;
    use App\Helpers\Validate;
    use App\Repositories\FreeTimeRepository;
    use App\Repositories\RoleRepository;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Log;

    class FreeTimeService
    {
        protected $freeTimeRepository;

        /**
         * @param $freeTimeRepository
         */


        public function __construct(FreeTimeRepository $freeTimeRepository)
        {
            $this->freeTimeRepository = $freeTimeRepository;
        }

        public function store($data)
        {
            $result = [];
            foreach ($data['freetime'] as $item) {
                if (Validate::validateDate($item['startTime']) || Validate::validateDate($item['endTime'])) {
                    throw new FreetimeException('Time does not match the format Y-m-d H:i:s.');
                }
                $startTime = Carbon::parse($item['startTime']);
                $endTime = Carbon::parse($item['endTime']);
                if ($startTime->isPast()) {
                    $now = new \DateTime();
                    throw new FreetimeException(FreeTimeMessage::ERROR_DATE . $now->format('Y-m-d H:i:s'));
                }
                if ($startTime > $endTime) {
                    throw new FreetimeException(FreeTimeMessage::ERROR_COMPARE_DATE);
                }
                $item['doctor_id'] = $data['doctor_id'];
                $this->freeTimeRepository->storeFreeTime($item);
                array_push($result, $this->freeTimeRepository->create($item));
            }
            return DataReturn::Result($result);
        }

        public function getAllFreeTime()
        {
            return DataReturn::Result($this->freeTimeRepository->all());
        }

        public function getRoleById($id)
        {
            if (!$this->checkFreeTimeIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->freeTimeRepository->findWhere(['id' => $id]));
        }

        public function checkFreeTimeIsExist($id)
        {
            return !is_null($this->freeTimeRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkFreeTimeIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->freeTimeRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkFreeTimeIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->freeTimeRepository->delete($id));
        }
    }
