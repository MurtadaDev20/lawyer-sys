<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen">
    <!-- Mobile Menu Button -->
    
    <button id="mobileMenuButton" class="fixed top-4 left-4 z-50 md:hidden p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
<aside id="sidebar" class="fixed top-0 right-0 h-screen w-72 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out translate-x-full md:translate-x-0 z-40">
        <!-- Logo and Brand -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <div class="p-2 bg-primary-100 dark:bg-primary-900 rounded-lg">
                    <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">نظام المحاماة</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">لوحة التحكم</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4">
            <div class="space-y-1">
                <h3 class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    الرئيسية
                </h3>
                <a href="{{ route('lawyer.dashboard') }}" wire:navigate class="flex items-center px-4 py-3 text-primary-600 bg-primary-50 dark:bg-primary-900/50 rounded-lg">
                    <svg class="h-5 w-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>لوحة التحكم</span>
                </a>
            </div>

            <div class="mt-8 space-y-1">
                <h3 class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    إدارة المحتوى
                </h3>
                <a href="{{ route('lawyer.archive') }}" wire:navigate class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-primary-50 dark:hover:bg-primary-900/50 rounded-lg transition-colors">
                    <svg class="h-5 w-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span>الأرشيف</span>
                </a>
                <a href="lawyer-clients.html" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-primary-50 dark:hover:bg-primary-900/50 rounded-lg transition-colors">
                    <svg class="h-5 w-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>العملاء</span>
                </a>
            </div>

            <div class="mt-8 space-y-1">
                <h3 class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    الإعدادات
                </h3>
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 hover:bg-primary-50 dark:hover:bg-primary-900/50 rounded-lg transition-colors">
                    <svg class="h-5 w-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>الإعدادات</span>
                </a>
                @livewire('lawery.auth.logout')
            </div>

            <!-- User Profile Card -->
            <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{Auth::user()->name}}&background=22c55e&color=fff" alt="Profile">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{Auth::user()->name}}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">محامي</p>
                    </div>
                </div>
            </div>
        </nav>
    </aside>