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
            <p class="text-gray-600 dark:text-gray-400 mt-2">إعادة تعيين كلمة المرور</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-6">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">التقدم</span>
                <span class="text-sm font-medium text-primary-600 dark:text-primary-400">{{ $currentStep }}/{{ $totalSteps }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <!-- Wizard Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <!-- Step 1: Phone Number -->
            @if($currentStep === 1)
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رقم الهاتف</label>
                    <input 
                        type="text" 
                        wire:model="phone" 
                        required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                        placeholder="أدخل رقم هاتفك"
                    >
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button 
                        type="button" 
                        wire:click="nextStep" 
                        class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-6 rounded-lg transition-colors"
                    >
                        التالي
                    </button>
                </div>
            </div>
            @endif

            <!-- Step 2: OTP Verification -->
            @if($currentStep === 2)
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رمز التحقق</label>
                    <input 
                        type="text" 
                        wire:model="otp" 
                        required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                        placeholder="أدخل رمز التحقق المكون من 6 أرقام"
                    >
                    @error('otp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-between">
                    <button 
                        type="button" 
                        wire:click="previousStep" 
                        class="text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 font-medium py-2 px-6 rounded-lg transition-colors"
                    >
                        السابق
                    </button>
                    <div class="flex items-center space-x-4">
                        <button 
                            type="button" 
                            wire:click="resendOtp" 
                            class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300"
                        >
                            إعادة إرسال الرمز
                        </button>
                        <button 
                            type="button" 
                            wire:click="nextStep" 
                            class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-6 rounded-lg transition-colors"
                        >
                            التالي
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Step 3: New Password -->
            @if($currentStep === 3)
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">كلمة المرور الجديدة</label>
                    <input 
                        type="password" 
                        wire:model="password" 
                        required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                        placeholder="أدخل كلمة المرور الجديدة"
                    >
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تأكيد كلمة المرور</label>
                    <input 
                        type="password" 
                        wire:model="password_confirmation" 
                        required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                        placeholder="أعد إدخال كلمة المرور الجديدة"
                    >
                    @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-between">
                    <button 
                        type="button" 
                        wire:click="previousStep" 
                        class="text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 font-medium py-2 px-6 rounded-lg transition-colors"
                    >
                        السابق
                    </button>
                    <button 
                        type="button" 
                        wire:click="submit" 
                        class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-6 rounded-lg transition-colors"
                    >
                        إعادة تعيين كلمة المرور
                    </button>
                </div>
            </div>
            @endif
        </div>

        <!-- Help Text -->
        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
            @if($currentStep === 1)
            سنرسل رمز تحقق إلى رقم هاتفك لإعادة تعيين كلمة المرور
            @elseif($currentStep === 2)
            أدخل رمز التحقق الذي استلمته على رقم هاتفك
            @elseif($currentStep === 3)
            اختر كلمة مرور جديدة لحسابك
            @endif
        </p>
    </div>
</div>