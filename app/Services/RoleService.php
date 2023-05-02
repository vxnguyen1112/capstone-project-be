<?php

    namespace App\Services;

    use App\Helpers\DataReturn;
    use App\Helpers\HttpCode;
    use App\Repositories\RoleRepository;
    use Illuminate\Support\Facades\Log;

    class RoleService
    {
        protected $roleRepository;


        /**
         * @param $roleRepository
         */


        public function __construct(RoleRepository $roleRepository)
        {
            $this->roleRepository = $roleRepository;
        }

        public function store($data)
        {
            return DataReturn::Result($this->roleRepository->create($data));
        }

        public function getAllRole()
        {
            return DataReturn::Result($this->roleRepository->all());
        }

        public function getRoleById($id)
        {
            if (!$this->checkRoleIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->roleRepository->findWhere(['id' => $id]));
        }

        public function checkRoleIsExist($id)
        {
            return !is_null($this->roleRepository->findWhere(['id' => $id])->first());
        }

        public function update($data, $id)
        {
            if (!$this->checkRoleIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->roleRepository->update($data, $id));
        }

        public function delete($id)
        {
            if (!$this->checkRoleIsExist($id)) {
                return DataReturn::Result(status: HttpCode::NOT_FOUND);
            }
            return DataReturn::Result($this->roleRepository->delete($id));
        }
    }
