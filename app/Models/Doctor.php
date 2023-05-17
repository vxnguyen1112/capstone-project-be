<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Doctor extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'specialization',
            'yearsOfExperience',
            'practiceLocation',
            'account_id',
            'cv'
        ];

        public function account()
        {
            return $this->belongsTo(Account::class)->with('information', 'information.address');
        }

        public function free_times()
        {
            return $this->hasMany(Free_time::class)->oldest('startTime');
        }
        public function appointments()
        {
            return $this->hasMany(Appointment::class)->latest();
        }
    }
