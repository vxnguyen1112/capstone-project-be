<?php

    namespace App\Models;

    use App\Helpers\UUID;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class Account extends Authenticatable implements JWTSubject
    {
        use  HasFactory, Notifiable;
        use UUID;

        protected $fillable = [
            'display_name',
            'email',
            'password',
            'avatar_url',
            'role_id',
            'information_id',
            'is_verified'
        ];
        protected $hidden = [
            'password'
        ];

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }

        public function getJWTCustomClaims()
        {
            return [];
        }

        public function information()
        {
            return $this->belongsTo(Information::class);
        }
    }
