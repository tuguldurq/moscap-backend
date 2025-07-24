<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublisherAccountant extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    CONST SURNAME            = 'surname';
    CONST PUBLISHER_ID           = 'publisher_id';
    CONST ACCOUNT_NUMBER           = 'account_number';
    CONST POSITION = 'position';
    CONST PHONE         = 'phone';
    CONST EMAIL         = 'email';
    CONST BANK         = 'bank';
    
    protected $fillable = [
        self::SURNAME,
        self::PUBLISHER_ID,
        self::ACCOUNT_NUMBER,
        self::POSITION,
        self::PHONE,
        self::EMAIL,
        self::BANK,
    ];
}
