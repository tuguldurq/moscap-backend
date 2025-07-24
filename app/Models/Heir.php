<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reference\ContactType;
use Illuminate\Support\Str;

class Heir extends Model
{
    use HasFactory, SoftDeletes;
    protected $with = ['type'];
    protected $fillable = [
        'user_id',
        'first_name', 
        'last_name', 
        'register_number',
        'type',
        'email',
        'phone',
        'file_path', 
    ];

    public function type(){
        return $this->belongsTo(ContactType::class, 'type');
    }

    public function getPhoneAttribute($value){
        if($value != null)
        {
            $phone = explode(" ", $value);
            return ['prefix' => $phone[0], 'number' => $phone[1]];
        }else{
            return $value;
        }
    }

    public function setPhoneAttribute($value){
        if(is_array($value)){
            $this->attributes['phone'] = $value['prefix']." ".$value['number'];
        }else{
            $this->attributes['phone'] = $value;
        }
    }

    // public function getRegisterNumberAttribute($value){
    //     return ['letter1' => Str::substr($value, 0, 1), 'letter2' => Str::substr($value, 1, 1), 'number' => Str::substr($value, 2, strlen($value) - 1)];
    // }

    public function setRegisterNumberAttribute($value){
        if(is_array($value)){
            $this->attributes['register_number'] = $value['letter1'].$value['letter2'].$value['number'];
        }else{
            $this->attributes['register_number'] = $value;
        }
    }
}
