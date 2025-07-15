<div>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center p-3 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold">نظام المحاماة</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">التحقق من الرمز</p>
        </div>

        <!-- OTP Verification Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <form wire:submit.prevent="verifyOtp" class="space-y-6">
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">أدخل الرمز المرسل إلى رقم الهاتف</label>
                    <div class="flex gap-2 justify-center">
                        <input 
                            type="text" 
                            wire:model="otp"
                            maxlength="6" 
                            inputmode="numeric" 
                            class="text-center text-2xl font-bold rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                            
                        >
                    </div>
                    @error('otp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    تحقق
                </button>

                <div class="text-center space-y-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        لم يصلك الرمز؟
                        <button 
                            type="button" 
                            wire:click="resendOtps"
                            @if($resendDisabled) disabled @endif
                            class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium @if($resendDisabled) opacity-50 cursor-not-allowed @endif"
                        >
                            إعادة الإرسال
                        </button>
                    </p>
                    @php
                        $referer = request()->header('Referer');
                        if (str_contains($referer, 'customer/auth/otp-verification')) {
                            $backUrl = route('customer.login');
                        } elseif (str_contains($referer, 'lawyer/auth/otp-verification')) {
                            $backUrl = route('lawyer.login');
                        } else {
                            $backUrl = route('edara.login');
                        }
                    @endphp
                    <a href="{{ $backUrl }}" class="block text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                        العودة إلى تسجيل الدخول
                    </a>
                </div>
            </form>
        </div>

        <!-- Timer -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                يمكنك طلب رمز جديد بعد
                <span class="font-medium text-primary-600 dark:text-primary-400">
                    {{ gmdate('i:s', $countdown) }}
                </span>
            </p>
        </div>
    </div>

    
    <script>
        document.addEventListener('livewire:init', function() {
            let timer;

            // Start timer when event received
            Livewire.on('start-otp-timer', () => {
                clearInterval(timer); // Clear any existing timer
                timer = setInterval(() => {
                    @this.decrementCountdown();
                }, 1000);
            });

            // Stop timer when event received
            Livewire.on('stop-timer', () => {
                clearInterval(timer);
            });

            // Start initial timer when component loads
            Livewire.on('component-mounted', () => {
                Livewire.dispatch('start-otp-timer');
            });
        });
</script>
</div>