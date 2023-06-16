<?php

    namespace App\Repositories\Eloquent;

    use App\Models\Medical_record;
    use App\Models\Role;
    use App\Repositories\MedicalRecordRepository;
    use App\Repositories\RoleRepository;
    use Prettus\Repository\Criteria\RequestCriteria;
    use Prettus\Repository\Eloquent\BaseRepository;


    class MedicalRecordRepositoryEloquent extends BaseRepository implements MedicalRecordRepository
    {
        public function model()
        {
            return Medical_record::class;
        }

        public function boot()
        {
            $this->pushCriteria(app(RequestCriteria::class));
        }

        public function getMedicalRecordByDoctorId($id)
        {
            return Medical_record::where(['doctor_id' => $id])->with(['patient','doctor','medications'])->latest()->get();
        }

        public function getMedicalRecordByPatientId($id)
        {
            return Medical_record::where(['patient_id' => $id])->with(['patient','doctor','medications'])->latest()->get();
        }

    }
