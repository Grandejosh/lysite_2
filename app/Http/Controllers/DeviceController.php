<?php

namespace App\Http\Controllers;

use App\Models\UserDevice;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function verify($id)
    {
        $device = UserDevice::findOrFail($id);

        if ($device->is_verified) {
            return redirect('/')->with('message', 'El dispositivo ya está verificado.');
        }

        $device->update(['is_verified' => true]);

        return redirect('/')->with('message', 'El dispositivo ha sido verificado correctamente.');
    }
}
