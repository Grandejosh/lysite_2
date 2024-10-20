<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public $user_id = null;
    public $username = null;
    public $description = null;
    public $avatar = null;
    public $np = true;
    public $pp = true;
    public $avatar_show = null;

    public function mount(){
        $this->user_id = Auth::id();
        
        $this->username = Auth::user()->name;
        $this->description = Auth::user()->description;
        $this->np = Auth::user()->np;
        $this->pp = Auth::user()->pp;
    }

    public function render()
    {
        $this->avatar_show = User::find($this->user_id)->avatar;
        return view('livewire.user.edit-profile');
    }

    public function save(){
        $this->validate([
            'username' => 'required'
        ]);

        $path_avatar = null;

        if($this->avatar){

            $this->validate([
                'avatar' => 'max:2048|mimes:jpg,jpeg,png'
            ]);

            $name = Auth::id().'.png';
  
            $path_avatar = $this->avatar->storeAs('avatars', $name, 'public');
 
        }else{
            $path_avatar = $this->avatar_show;
        }

        User::where('id',$this->user_id)->update([
            'name' => $this->username,
            'avatar' => $path_avatar,
            'description' => $this->description,
            'np' => $this->np ? true : false,
            'pp' => $this->pp ? true : false
        ]);

        $this->dispatchBrowserEvent('set-user-update', ['tit' => 'Enhorabuena','msg' => 'Se actualizó correctamente']);
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'max:2048|mimes:jpg,jpeg,png'
        ]);
    }
}
