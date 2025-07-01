<div>
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl font-bold">لوحة التحكم</h1>
                <p class="text-gray-600 dark:text-gray-400">مرحباً بك في نظام إدارة المحاماة</p>
            </div>
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 focus:outline-none">
                    <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </button>
                <!-- Calendar -->
                <button class="p-2 text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </button>
                <!-- Profile -->
                <button class="flex items-center space-x-2 rtl:space-x-reverse focus:outline-none">
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{Auth::user()->name}}&background=22c55e&color=fff" alt="Profile">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{Auth::user()->name}}</span>
                </button>
            </div>
        </div>

        <!-- Welcome Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 mb-8">
            <h1 class="text-2xl font-bold mb-2">مرحباً،  {{Auth::user()->name}}</h1>
            <p class="text-gray-600 dark:text-gray-400">هذه لوحة تحكم المحامي حيث يمكنك إدارة أرشيفك وعملائك</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Clients -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900 rounded-lg">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-green-600 dark:text-green-400">+12% هذا الشهر</span>
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ \App\Models\CustomerLawyer::where('lawyer_id',Auth::id())->count() }}</h3>
                <p class="text-gray-600 dark:text-gray-400">إجمالي العملاء</p>
            </div>

            <!-- Active Cases -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-blue-600 dark:text-blue-400">+5% هذا الشهر</span>
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ \App\Models\Casee::where('lawyer_id',Auth::id())->count() ?? 0 }}</h3>
                <p class="text-gray-600 dark:text-gray-400">القضايا</p>
            </div>

            <!-- Total Folders -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-purple-600 dark:text-purple-400">+8% هذا الشهر</span>
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ \App\Models\Folder::where('lawyer_id',Auth::id())->count() ?? 0 }}</h3>
                <p class="text-gray-600 dark:text-gray-400">المجلدات</p>
            </div>

            <!-- Total Files -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-yellow-600 dark:text-yellow-400">+15% هذا الشهر</span>
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ \App\Models\File::where('lawyer_id',Auth::id())->count() ?? 0 }}</h3>
                <p class="text-gray-600 dark:text-gray-400">الملفات</p>
            </div>
            <!-- Total Files -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-yellow-600 dark:text-yellow-400">+15% هذا الشهر</span>
                </div>
                @php
                    use App\Models\File;
                    use Illuminate\Support\Facades\Auth;

                    $files = File::where('lawyer_id', Auth::id())->get();
                    $totalAttachments = $files->reduce(function ($carry, $file) {
                        return $carry + $file->getMedia('documents')->count();
                    }, 0);
                @endphp
                <h3 class="text-2xl font-bold mb-1">{{ $totalAttachments }}</h3>

                <p class="text-gray-600 dark:text-gray-400">المرفقات</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Archives Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">الأرشيف</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">إدارة ملفاتك وأرشيفك القانوني</p>
                <a href="{{ route('lawyer.archive') }}" wire:navigate class="inline-block px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    الانتقال إلى الأرشيف
                </a>
            </div>

            <!-- Clients Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">العملاء</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">إدارة عملائك وقضاياهم</p>
                <a href="{{ route('lawyer.customerManage') }}" wire:navigate class="inline-block px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    الانتقال إلى العملاء
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">النشاط الأخير</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <p class="font-medium">تم إضافة ملف جديد</p>
                        <p class="text-sm text-gray-500">قضية تجارية - محمد علي</p>
                    </div>
                    <span class="text-sm text-gray-500">منذ ساعتين</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <p class="font-medium">تم تحديث حالة القضية</p>
                        <p class="text-sm text-gray-500">قضية مدنية - أحمد خالد</p>
                    </div>
                    <span class="text-sm text-gray-500">منذ 3 ساعات</span>
                </div>
            </div>
        </div>
    </main>
</div>
