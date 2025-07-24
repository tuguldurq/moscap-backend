<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reference\ContactType;

class EmergencyContact extends Model
{
    use HasFactory, SoftDeletes;
    protected $with = ['type'];

    protected $fillable = ['user_id', 'name', 'type_id', 'phone'];

    public function type(){
        return $this->belongsTo(ContactType::class);
    }
}
