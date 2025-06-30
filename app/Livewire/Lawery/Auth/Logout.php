<?php

namespace App\Livewire\Lawery\Auth;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('lawyer.login');
    }
    public function render()
    {
        return view('livewire.lawery.auth.logout');
    }
}
