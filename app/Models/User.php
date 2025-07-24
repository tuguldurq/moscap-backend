<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Models\EmergencyContact;
use App\Models\Publisher;
use App\Models\Heir;
use App\Models\Artist;
use App\Models\ArtistManager;
use App\Models\UserBanks;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    CONST FIRST_NAME      = 'first_name';
    CONST LAST_NAME       = 'last_name';
    CONST EMAIL           = 'email';
    CONST PHONE           = 'phone';
    CONST SEX             = 'sex';
    CONST REGISTER_NUMBER = 'register_number';
    CONST CITIZEN         = 'citizen';
    CONST ROLE            = 'role';
    CONST PASSWORD        = 'password';

    
    protected $fillable = [
        self::FIRST_NAME,
        self::LAST_NAME,
        self::EMAIL,
        self::PHONE,
        self::SEX,
        self::REGISTER_NUMBER,
        self::CITIZEN,
        self::ROLE,
        self::PASSWORD,
    ];

    protected $with = ['bank', 'emergency', 'heir', 'artist'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::PASSWORD,
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function artist(){
        return $this->hasOne(Artist::class)->withCount(['composerSongs', 'authorSongs']);
    }

    public function managers(){
        return $this->hasManyThrough(ArtistManager::class, Artist::class);
    }

    public function emergency(){
        return $this->hasMany(EmergencyContact::class);
    }

    public function bank(){
        return $this->hasOne(UserBanks::class);
    }

    public function heir(){
        return $this->hasOne(Heir::class);
    }

    public function publisher(){
        return $this->hasOne(Publisher::class);
    }
}
