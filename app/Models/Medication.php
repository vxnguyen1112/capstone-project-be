<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Medication extends Model
    {
        use HasFactory;
        use UUID;

        protected $fillable = [
            'name',
            'dosage',
            'frequency',
            'reason',
            'route',
            'medical_record_id',
        ];

    }
