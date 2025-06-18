<?php

namespace App\Livewire\Edara\Auth;

use App\Helpers\PhoneCleanerHelper;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use App\Traits\SendsOtp;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

class LoginEdara extends Component
{
     use SendsOtp;
    
    public $phone;
    public $password;
    public $remember = false;

    public function rules()
    {
        return [
            'phone' => ['required', 'regex:/^07[0-9]{9}$/'], // Egyptian phone number pattern
            'password' => ['required', 'string', 'min:8'],
            'remember' => ['boolean'],
        ];
    }

    public function login()
    {
        $this->validate();

        $phoneNumber = (new PhoneCleanerHelper($this->phone))->clean();
        if ($phoneNumber == false) {
            return toastr()->error('رقم الهاتف غير صحيح.');
        }

        $credentials = [
            'phone' => $phoneNumber,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            $user = User::where('phone', $phoneNumber)->first();

            if (!$user->is_verified) {
                Auth::logout();
                
                // Use the trait method
                if ($this->sendOtp($user)) {
                    toastr()->success('تم إرسال رمز التحقق إلى رقم هاتفك. يرجى التحقق منه.');
                    return redirect()->route('edara.otp-verification');
                }
                
                return back()->with('error', 'فشل إرسال رمز التحقق، يرجى المحاولة مرة أخرى.');
            }

            return toastr()->success('تم تسجيل الدخول بنجاح.');
        }

        return toastr()->error('بيانات الدخول غير صحيحة.');
    }

    public function render()
    {
        return view('livewire.edara.auth.login-edara');
    }
}
