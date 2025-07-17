<?php

namespace App\Livewire\Customer\Auth;

use App\Models\User;
use Livewire\Component;
use App\Traits\SendsOtp;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Helpers\PhoneCleanerHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginCustomer extends Component
{
    use SendsOtp;

    #[Layout('components.layouts.customer.login')] 
    #[Title('تسجيل الدخول')] 

    public $phone;
    public $password;
    public $remember = false;

    public function rules()
    {
        return [
            'phone' => ['required'], 
            'password' => ['required', 'string', 'min:8'],
            'remember' => ['boolean'],
        ];
    }

    public function mount()
    {
        if (Auth::check()) {
                toastr()->warning('أنت مسجل دخول بالفعل.');
                return redirect()->route('customer.dashboard');
            
        }
    }

    public function login()
    {
        $this->validate();

        $phoneNumber = (new PhoneCleanerHelper($this->phone))->clean();
        if ($phoneNumber == false) {
            return toastr()->error('رقم الهاتف غير صحيح.');
        }

        $throttleKey = Str::lower($phoneNumber) . '|' . request()->ip();

        // Too many attempts
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return toastr()->error("تم حظر المحاولة مؤقتًا. حاول مرة أخرى بعد {$seconds} ثانية.");
        }

        $credentials = [
            'phone' => $phoneNumber,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();
            RateLimiter::clear($throttleKey); // Reset on success

            $user = User::where('phone', $phoneNumber)->first();
            if (!$user) {
                return toastr()->error('المستخدم غير موجود.');
            }

            if (!$user->hasRole('Customer')) {
                Auth::logout();
                return toastr()->error('ليس لديك صلاحيات للوصول إلى هذه الصفحة.');
            }

            if (!$user->is_active) {
                Auth::logout();
                return toastr()->error('حسابك غير مفعل، يرجى التواصل مع الإدارة.');
            }

            if (!$user->is_verified) {
                Auth::logout();
                    toastr()->success('يرجى التحقق من هاتفك');
                    return redirect()->route('customer.reset-password');
                
            }
            
            toastr()->success('تم تسجيل الدخول بنجاح.');
            return redirect()->intended(route('customer.dashboard'));
        }

        // Failed attempt, increment count
        RateLimiter::hit($throttleKey, 60); // Lock for 60 seconds

        return toastr()->error('بيانات الدخول غير صحيحة.');
    }

    public function render()
    {
        return view('livewire.customer.auth.login-customer');
    }
}
