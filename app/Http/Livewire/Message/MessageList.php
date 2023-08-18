<?php

namespace App\Http\Livewire\Message;

use App\Models\Message;
use App\Models\Partisipant;
use App\Models\User;
use Livewire\Component;


class MessageList extends Component
{
    public $search;

    public $getUserId;
    public $getUserName;
    public $getUserEmail;
    public $getConversationId;
    public $getMessage = "";

    public $onClickChat = "hidden";
    public $onAfterClickUser = "";

    public $screenWidth = 1024;

    protected $listeners = ['screenWidth' => 'updateScreenWidth'];

    public function updateScreenWidth($width)
    {
        $this->screenWidth = $width;
    }

    public function markAsRead($messageId)
    {
        $message = Message::find($messageId);
        if ($message && !$message->is_read && $message->user_id != auth()->user()->id) {
            $message->update(['is_read' => true]);
        }
    }

    public function selectConversation(Partisipant $partisipant)
    {
        $this->getConversationId = $partisipant->conversation_id;
        $this->getUserId = $partisipant->user_id;

        // dd($partisipant->toArray());
        $user = User::where('id', $this->getUserId)->first();
        $this->getUserName = $user->name;
        $this->getUserEmail = $user->email;

        $this->onClickChat = "";
        $this->onAfterClickUser = "hidden";
        // if ($this->screenWidth <= 768) {
        //     $this->onClickChat = "";
        //     $this->onAfterClickUser = "hidden";
        // }
    }

    public function onBackClick()
    {
        $this->reset(['onClickChat', 'onAfterClickUser', 'getConversationId', 'getUserId', 'getUserName', 'getUserEmail']);
        $this->resetErrorBag();
    }

    public function sendMessage()
    {
        $this->validate([
            'getMessage' => 'required|max:255',
        ]);

        Message::create([
            'user_id' => auth()->user()->id,
            'conversation_id' => $this->getConversationId,
            'message' => $this->getMessage,
        ]);

        $this->removeContent();
    }

    public function removeContent()
    {
        // $this->getContent = "";
        $this->reset(['getMessage']);
        $this->resetErrorBag();
    }

    public function mobileSize()
    {
    }


    public function render()
    {
        $authUserId = auth()->user()->id;

        $partisipants = Partisipant::with('user')
            ->whereHas('conversation.partisipants', function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            })
            ->where('user_id', '<>', $authUserId)
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        $messages = Message::where('conversation_id', $this->getConversationId)
            ->get();

        return view('livewire..message.message-list', compact('partisipants', 'messages'));
    }
}
