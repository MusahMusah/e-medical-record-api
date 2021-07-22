<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    // Attach timestamps on chats when updated
    protected $touches = ['chat'];

    // allow mass assignment of model instance
    protected $fillable = [
        'user_id', 'chat_id', 'body', 'last_read'
    ];

    // chat relationship
    public function chat () {
        return $this->belongsTo(Chat::class);
    }

    // User and Message relationship
    public function sender () {
        return $this->belongsTo(User::class, 'user_id');
    }

    // HELPER METHODS
    // Create Message Accessors
    public function getBodyAttribute($value)
    {
        if($this->trashed()){
            if(!auth()->check()) return null;
            return auth()->id() == $this->sender->id ?
                    'You deleted this message' :
                    "{$this->sender->name} deleted this message";
        }
        return $value;
    }
}
