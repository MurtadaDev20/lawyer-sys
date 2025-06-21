<?php

namespace App\Livewire\Edara\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('edara.login');
    }

    public function render()
    {
        return view('livewire.edara.auth.logout');
    }
}
