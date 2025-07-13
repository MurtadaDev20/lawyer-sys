<?php

namespace App\Livewire\Edara\Auth;

use App\Models\User;
use Livewire\Component;
use App\Traits\SendsOtp;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Helpers\PhoneCleanerHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginEdara extends Component
{
    use SendsOtp;

    #[Layout('components.layouts.edara.login')] 
    #[Title('تسجيل الدخول')] 

    public $phone;
    public $password;
    public $remember = false;

    public function rules()
    {
        return [
            'phone' => ['required', 'regex:/^07[0-9]{9}$/'], // Iraqi phone format
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

        $throttleKey = Str::lower($phoneNumber) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return toastr()->error("تم حظر المحاولة مؤقتًا. حاول مرة أخرى بعد {$seconds} ثانية.");
        }

        $credentials = [
            'phone' => $phoneNumber,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            RateLimiter::clear($throttleKey);

            $user = User::where('phone', $phoneNumber)->first();
            if (!$user) {
                return toastr()->error('المستخدم غير موجود.');
            }

            if (!$user->hasRole('Edara')) {
                Auth::logout();
                return toastr()->error('ليس لديك صلاحيات للوصول إلى هذه الصفحة.');
            }

            if (!$user->is_active) {
                Auth::logout();
                return toastr()->error('حسابك غير مفعل، يرجى التواصل مع الإدارة.');
            }

            if (!$user->is_verified) {
                if ($this->sendOtp($user)) {
                    toastr()->success('تم إرسال رمز التحقق إلى رقم هاتفك. يرجى التحقق منه.');
                    return redirect()->route('edara.otp-verification');
                }
                return back()->with('error', 'فشل إرسال رمز التحقق، يرجى المحاولة مرة أخرى.');
            }

            toastr()->success('تم تسجيل الدخول بنجاح.');
            return redirect()->route('edara.dashboard');
        }

        // Increment failed attempts
        RateLimiter::hit($throttleKey, 60);

        return toastr()->error('بيانات الدخول غير صحيحة.');
    }

    public function render()
    {
        return view('livewire.edara.auth.login-edara');
    }
}
