<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_health_worker',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_health_worker' => 'boolean',
    ];

    // RELATIONSHIPS
    // relationship for chat messaging
    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'participants');
    }

    // relationship for a specific user messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // HELPER METHODS
    // Helper to check if user is a health Worker
    public function isHealthWorker(): bool
    {
        return $this->is_health_worker;
    }

    // get chat with a specific user
    public function getChatWithUser($user_id)
    {
        $chat = $this->chats()
                ->whereHas('participants', function($query) use ($user_id)
                {
                    $query->where('user_id', $user_id);
                })
                ->first();
        return $chat;
    }
}
