<?php

namespace App\Livewire\Edara\Auth;

use Livewire\Component;
use App\Traits\SendsOtp;
use App\Models\User;
use App\Helpers\PhoneCleanerHelper;
use App\Models\UserOtp;

class ResetPassword extends Component
{
    use SendsOtp;

    public $currentStep = 1;
    public $totalSteps = 3;
    
    // Step 1 fields
    public $phone;
    
    // Step 2 fields
    public $otp;
    
    // Step 3 fields
    public $password;
    public $password_confirmation;
    
    public $user;
    public $progress = 0;

    protected $rules = [
        'phone' => 'required',
        'otp' => 'required|digits:6',
        'password' => 'required|min:8|confirmed',
    ];

    public function mount()
    {
        $this->updateProgress();
    }

    public function updateProgress()
    {
        $this->progress = (($this->currentStep - 1) / ($this->totalSteps - 1)) * 100;
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate(['phone' => 'required']);
            
            $phoneNumber = (new PhoneCleanerHelper($this->phone))->clean();
            if ($phoneNumber == false) {
                return toastr()->error('رقم الهاتف غير صحيح.');
            }

            $this->user = User::where('phone', $phoneNumber)->first();
            
            if (!$this->user) {
                return toastr()->error('لا يوجد حساب مرتبط بهذا الرقم.');
            }

            if ($this->sendOtp($this->user)) {
                $this->currentStep++;
                $this->updateProgress();
                return toastr()->success('تم إرسال رمز التحقق إلى رقم هاتفك.');
            }

            return toastr()->error('فشل إرسال رمز التحقق، يرجى المحاولة مرة أخرى.');
        }
        elseif ($this->currentStep === 2) {
            $this->validate(['otp' => 'required|digits:6']);

            $otpRecord = UserOtp::where('user_id', $this->user->id)
                ->where('otp_code', $this->otp)
                ->first();

            if ($otpRecord) {
                $otpRecord->update([
                    'is_otp_verified' => true,
                    'verified_at' => now(),
                ]);
                
                $this->user->update(['is_verified' => true]);
                $this->currentStep++;
                $this->updateProgress();
                return toastr()->success('تم التحقق بنجاح!');
            }

            $this->addError('otp', 'رمز التحقق غير صحيح أو منتهي الصلاحية.');
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->updateProgress();
        }
    }

    public function resendOtp()
    {
        if ($this->sendOtp($this->user)) {
            return toastr()->success('تم إعادة إرسال رمز التحقق.');
        }

        return toastr()->error('فشل إعادة إرسال رمز التحقق.');
    }

    public function submit()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Verify OTP again for security
        $otpRecord = UserOtp::where('user_id', $this->user->id)
            ->where('is_otp_verified', true)
            ->where('verified_at', '>', now()->subMinutes(30))
            ->first();

        if (!$otpRecord) {
            return toastr()->error('انتهت صلاحية التحقق. يرجى البدء من جديد.');
        }

        $this->user->update([
            'password' => bcrypt($this->password),
        ]);

        // Clear OTP record
        $otpRecord->delete();

        toastr()->success('تم إعادة تعيين كلمة المرور بنجاح!');
        return redirect()->route('edara.login');
    }

    public function render()
    {
        return view('livewire.edara.auth.reset-password');
    }
}