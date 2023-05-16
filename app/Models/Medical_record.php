<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Medical_record extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'name',
            'symptoms',
            'previous_conditions',
            'family_history',
            'test_results',
            'diagnosis',
            'treatment_plan',
            'allergies',
            'health_insurance',
            'note',
            'doctor_id',
            'patient_id',
        ];
        public function patient()
        {
            return $this->belongsTo(Account::class,'patient_id')->with('information', 'information.address');
        }
        public function doctor()
        {
            return $this->belongsTo(Doctor::class)->with('account');
        }
    }
