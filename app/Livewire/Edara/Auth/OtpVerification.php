<?php

namespace App\Livewire\Edara\Auth;

use Livewire\Component;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Auth;
use Twilio\TwiML\Voice\Stop;
use Livewire\Attributes\Layout;

class OtpVerification extends Component
{
    #[Layout('components.layouts.edara.login')] 
    public $otp = '';
    public $countdown = 5; // 3 minutes in seconds
    public $resendDisabled = true;

    protected $listeners = ['otpResent' => 'handleOtpResent'];

    public function mount()
    {
        $this->dispatch('start-otp-timer'); // Start timer on load
    }


    public function startCountdown()
    {
        $this->resendDisabled = true;
        $this->countdown = 5;
        
        // Update countdown every second
        $this->dispatch('start-otp-timer');
    }

    public function decrementCountdown()
    {
        if ($this->countdown <= 0) {
            $this->resendDisabled = false;
            $this->dispatch('stop-timer'); // Tell JS to stop the interval
            return;
        }
        
        $this->countdown--;
    }
    public function handleOtpResent()
    {
        $this->startCountdown();
         toastr()->success('تم إرسال رمز جديد إلى هاتفك.');
    }


     public function verifyOtp()
    {
        $this->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = Auth::user();
        $otpRecord = UserOtp::where('user_id', $user->id)
            ->where('otp_code', $this->otp)
            ->first();

        if ($otpRecord) {
            // Mark OTP as verified
            $otpRecord->update([
                'is_otp_verified' => true,
                'verified_at' => now(),
            ]);
            
            // Mark user as verified
            $user->update(['is_verified' => true]);
            
            
        $referer = request()->header('Referer');

        if (str_contains($referer, 'customer/auth/otp-verification')) 
            {
             toastr()->success('تم التحقق بنجاح!');
            return redirect()->route('customer.dashboard');
            } 
            elseif (str_contains($referer, 'lawyer/auth/otp-verification')) 
                {
                     toastr()->success('تم التحقق بنجاح!');
                    return redirect()->route('lawyer.dashboard');
                } 
                else {
                     toastr()->success('تم التحقق بنجاح!');
                    return redirect()->route('edara.dashboard');
                }
        }

        $this->addError('otp', 'رمز التحقق غير صحيح أو منتهي الصلاحية.');
    }   

    public function resendOtps()
    {
        $user = Auth::user();
        $this->dispatch('resend-otp-request', userId: $user->id)
            ->to(ResendOtp::class);
        $this->startCountdown();
    }

    public function render()
    {
        return view('livewire.edara.auth.otp-verification');
    }
}
