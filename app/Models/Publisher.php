<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PublisherAccountant;

class Publisher extends Model
{
    use HasFactory, SoftDeletes;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    CONST SURNAME            = 'surname';
    CONST ENGLISH_NAME       = 'english_name';
    CONST TYPE           = 'type';
    CONST ACTIVITY_TYPE           = 'activity_type';
    CONST PERSON_NAME             = 'person_name';
    CONST PERSON_POSITION = 'person_position';
    CONST PERSON_PHONE         = 'person_phone';
    CONST USER_ID            = 'user_id';

    protected $fillable = [
        self::SURNAME,
        self::ENGLISH_NAME,
        self::TYPE,
        self::ACTIVITY_TYPE,
        self::PERSON_NAME,
        self::PERSON_POSITION,
        self::PERSON_PHONE,
        self::USER_ID,
    ];

    public function publisherAccountant(){
        return $this->hasOne(PublisherAccountant::class);
    }
}
