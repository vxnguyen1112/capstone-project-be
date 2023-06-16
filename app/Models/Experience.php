<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Experience extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'job_title',
            'workplace',
            'description',
            'start_date',
            'end_date',
            'doctor_id'
        ];

    }
