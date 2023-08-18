<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    // fuction untuk mengambil url foto profil

    public function getProfilePhotoUrlAttribute()
    {
        return asset('storage/' . $this->profile_photo_path);
    }

    public function isOnline()
    {
        return $this->last_activity;
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function partisipants()
    {
        return $this->hasMany(Partisipant::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'partisipants');
    }
}
