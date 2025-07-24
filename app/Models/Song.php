<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'song_code',
        'origin_name',
        'english_name',
        'author_id',
        'composer_id',
        'performer',
        'type',
        'category',
        'year',
        'lang',
    ];

    public function composer(){
        return $this->belongsTo(Artist::class, 'composer_id');
    }

    public function author(){
        return $this->belongsTo(Artist::class, 'author_id');
    }

    public static function generateCode()
    {
        $lastItem = self::orderBy('id', 'desc')->first(); // Get the last item
        $prefix = 'M'; // Set a prefix for the code if needed
        
        if ($lastItem) {
            $lastCode = $lastItem->song_code;
            $lastNumber = (int) substr($lastCode, strlen($prefix)); // Extract the number from the last code
            $nextNumber = $lastNumber + 1; // Increment the number
            $code = $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT); // Generate the new code
        } else {
            $code = $prefix . '000001'; // If no previous code exists, start with the initial code
        }
        
        return $code;
    }
    protected static function boot()
    {
        parent::boot();
     
        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('origin_name', 'asc');
        });
    }
}
