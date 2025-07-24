<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ArtistManager;
use App\Models\User;
use App\Models\Heir;
use Carbon\Carbon;
use App\Models\Song;

class Artist extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['managers'];

    protected $fillable = [
        'band_name',
        'stage_name',
        'ipi_code',
        'type',
        'mgl_code',
        'user_id',
        'release_type'
    ];
    // $user->is_admin gj handah bolomjtoi bolno.
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class)->withDefault();
    }
    // public function author() {
    //     return $this->hasMany(Song::class, 'author_id');
    // }
    // public function composer() {
    //     return $this->hasMany(Song::class, 'composer_id');
    // }
    public function songs()
    {
        return $this->hasMany(Song::class, 'author_id')
            ->orWhere('composer_id', $this->id);
    }

    public function composerSongs(){
        return $this->hasMany(Song::class, 'composer_id');
    }

    public function authorSongs(){
        return $this->hasMany(Song::class, 'author_id');
    }

    public function managers(){
        return $this->hasMany(ArtistManager::class);
    }
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function heir(){
        return $this->hasOne(Heir::class);
    }
    

    // serialize
    public function setReleaseTypeAttribute($value)
    {
        $this->attributes['release_type'] = serialize($value);
    }

    public function getReleaseTypeAttribute($value)
    {
        return unserialize($value);
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
