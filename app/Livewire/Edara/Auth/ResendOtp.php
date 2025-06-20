<?php

namespace App\Livewire\Edara\Auth;

use App\Models\User;
use App\Traits\SendsOtp;
use Livewire\Component;

class ResendOtp extends Component
{
    use SendsOtp;

    protected $listeners = [
        'resend-otp-request' => 'handleResendRequest'
    ];

    public function handleResendRequest($userId)
    {
        dd($userId);
        $user = User::find($userId);
        
        if ($user) {
            $this->sendOtp($user);
            $this->dispatch('otp-resent');
        }
    }
    public function render()
    {
        return view('livewire.edara.auth.resend-otp');
    }
}
