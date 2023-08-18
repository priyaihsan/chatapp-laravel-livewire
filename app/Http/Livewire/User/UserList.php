<?php

namespace App\Http\Livewire\User;

use App\Models\Conversation;
use App\Models\Partisipant;
use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    public $search;

    public $getId;
    public $getName;
    public $getEmail;

    public function edit(User $user)
    {
        $user = User::find($user->id);
        $this->getName = $user->name;
        $this->getEmail = $user->email;
        $this->getId = $user->id;
        $this->resetErrorBag();
    }

    public function updateUser($userId)
    {
        $this->validate([
            'getName' => 'required|max:255',
            'getEmail' => 'required|email',
        ]);

        $user = User::where('id', $userId);

        $user->update([
            'name' => $this->getName,
            'email' => $this->getEmail,
        ]);

        $this->cancelUpdate();

        session()->flash('success', 'User information updated successfully.');
        return redirect()->back();
    }

    public function cancelUpdate()
    {
        //     $this->getId = null;
        //     $this->getName = null;
        //     $this->getEmail = null;
        $this->reset(['getName', 'getEmail', 'getId']);
        $this->resetErrorBag();
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function createConversation(User $user)
    {
        $name = auth()->user()->id . ' with ' . $user->id;

        if (Conversation::where('name', $name)->exists()) {
            return redirect()->back()->with('error', 'Conversation already exists.');
        } else {
            $conversation = Conversation::create([
                'name' =>  $name,
            ]);
            Partisipant::create([
                'user_id' => auth()->user()->id,
                'conversation_id' => $conversation->id,
            ]);
            Partisipant::create([
                'user_id' => $user->id,
                'conversation_id' => $conversation->id,
            ]);
            return redirect()->route('message')->with('success', 'Conversation created successfully.');
        }
    }

    public function render()
    {
        $users = User::all();

        if($this->search){
            $users = User::where('name', 'like', '%'.$this->search.'%')->get();
        }

        return view('livewire..user.user-list', compact('users'));
    }
}
