<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditAvatar extends Component
{
    use WithFileUploads;
 
    public $photo;
    public $password_old;

    public function render()
    {
        return view('livewire.user.edit-avatar');
    }

    protected $rules = [
        'photo' => 'image|max:1024|mimes:jpg,jpeg,png',
    ];

    public function updated($propertyPhoto)
    {
        $this->validateOnly($propertyPhoto);
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|max:2048', // 1MB Max
        ]);

        if (Hash::check($this->password_old, Auth::user()->password)) {

            $name = Auth::id().'.png';
            $path = $this->photo->storeAs('avatars', $name, 'public');

            User::find(Auth::id())->update([
                'avatar' => $path
            ]);

            $this->photo = null;
            $this->password_old = null;

            $this->dispatchBrowserEvent('set-user-password-update', ['tit' => 'Enhorabuena','msg' => 'Se actualizó correctamente']);
        } else {
            $this->dispatchBrowserEvent('set-user-password-notupdate', ['tit' => 'Error','msg' => 'La contraseña ingresada no coincide con actual']);
        }

        
    }
}
