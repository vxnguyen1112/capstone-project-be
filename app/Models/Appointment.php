<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use PhpParser\Comment\Doc;

    class Appointment extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'status',
            'free_time_id',
            'doctor_id',
            'patient_id',
            'note'
        ];
        public function time()
        {
            return $this->belongsTo(Free_time::class,'free_time_id');
        }
        public function patient()
        {
            return $this->belongsTo(Account::class,'patient_id');
        }
        public function doctor()
        {
            return $this->belongsTo(Doctor::class);
        }

    }
