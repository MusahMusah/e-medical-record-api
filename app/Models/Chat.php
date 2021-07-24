<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

    public function messages()
    {
        return $this->HasMany(Message::class);
    }

    // HELPER METHODS
    public function getUserChats()
    {
        return auth()->user()->chats()
                    ->with(['messages', 'participants'])
                    ->get();
    }

    public function getLatestMessageAttribute()
    {
        return $this->messages()->latest->first();
    }

    public function isUnreadForUser($userId)
    {
        return (bool)$this->messages()
                ->whereNull('last_read')
                ->where('user_id', '<>', $userId)
                ->count();
    }

    public function markAsReadForUser($userId)
    {
        $this->messages()
            ->whereNull('last_read')
            ->where('user_id', '<>', $userId)
            ->update([
                'last_read' => Carbon::now()
            ]);
    }

}

