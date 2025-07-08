<?php

namespace App\Livewire\Customer\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
     public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('customer.login');
    }
    public function render()
    {
        return view('livewire.customer.auth.logout');
    }
}
