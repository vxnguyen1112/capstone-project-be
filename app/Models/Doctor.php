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
            'cv',
            'is_activated'
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
        public function feedback()
        {
            return $this->hasMany(Feedback::class)->oldest();
        }
        public function experiences()
        {
            return $this->hasMany(Experience::class)->latest();
        }
        public function studying_histories()
        {
            return $this->hasMany(Studying_history::class)->latest();
        }
    }
