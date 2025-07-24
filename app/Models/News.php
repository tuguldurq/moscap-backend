<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Images;

class News extends Model
{
    use HasFactory, SoftDeletes;
    protected $with = ['images'];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
    ];
    protected $fillable = [
        'title',
        'image',
        'description'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function images() {
        return $this->morphMany(Images::class, 'imageable');
    }

    protected static function boot()
    {
        parent::boot();
     
        // Order by name ASC
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }
}
