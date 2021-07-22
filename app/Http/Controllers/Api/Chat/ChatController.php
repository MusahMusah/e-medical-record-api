<?php

namespace App\Http\Controllers\Api\Chat;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;

class ChatController extends Controller
{
    // Send message to user
    public function sendMessage(MessageRequest $request)
    {
        $recipient = $request->recipient;
        $user = auth()->user();
        $body = $request->body;

        // check if there is an existing chat
        // between the auth user and the recipient
        $chat = $user->getChatWithUser($recipient);

        if(! $chat){
            $chat = Chat::create([]);
            $chat->participants()->sync([$user->id, $recipient]);
        }

        // add the message to the chat
        $message = Message::create([
            'user_id' => $user->id,
            'chat_id' => $chat->id,
            'body' => $body,
            'last_read' => null
        ]);

        return new MessageResource($message);
    }

    // Get chats for user
    public function getUserChats()
    {
        $chats = auth()->user()->chats()
                ->with(['messages', 'participants'])
                ->get();
        return ChatResource::collection($chats);
    }

    // get messages for chat
    public function getChatMessages($id)
    {
        $messages = $this->messages->withCriteria([
                        new WithTrashed()
                    ])->findWhere('chat_id', $id);

        return MessageResource::collection($messages);
    }

    // mark chat as read
    public function markAsRead($id)
    {
        $chat = $this->chats->find($id);
        $chat->markAsReadForUser(auth()->id());
        return response()->json(['message' => 'successful'], 200);
    }

    // destroy message
    public function destroyMessage($id)
    {
        $message = $this->messages->find($id);
        $this->authorize('delete', $message);
        $message->delete();
    }
}
