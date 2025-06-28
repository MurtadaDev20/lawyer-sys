<div>
    <!-- Main Content -->
    <main class="md:mr-72 p-4 md:p-8">
    
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">إحصائيات المستخدمين</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">مجموع المستخدمين</h3>
            <p class="text-3xl font-bold text-primary-600">{{ \App\Models\User::count() }}</p>
            <p class="text-sm text-gray-500 mt-2">+8% من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد موظفي الادارة</h3>
            <p class="text-3xl font-bold text-primary-600">{{ \App\Models\User::role('Edara')->count() }}</p>
            <p class="text-sm text-gray-500 mt-2">+8% من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد العملاء</h3>
            <p class="text-3xl font-bold text-primary-600">{{ \App\Models\User::role('Customer')->count() }}</p>
            <p class="text-sm text-gray-500 mt-2">+8% من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد المحامين</h3>
            <p class="text-3xl font-bold text-primary-600">{{ \App\Models\User::role('lawyer')->count() }}</p>
            <p class="text-sm text-gray-500 mt-2">+2 من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد المحامين المفعلين</h3>
            <p class="text-3xl font-bold text-primary-600">{{ \App\Models\User::role('lawyer')->where('is_active', true)->count() }}</p>
            <p class="text-sm text-gray-500 mt-2">+2 من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد المحامين غير المفعلين</h3>
            <p class="text-3xl font-bold text-red-600">{{ \App\Models\User::role('lawyer')->where('is_active', false)->count() }}</p>
            <p class="text-sm text-gray-500 mt-2">+2 من الشهر الماضي</p>
        </div>
        @php
            $todayLawyers = \App\Models\User::role('lawyer')
                ->whereDate('created_at', today())
                ->count();
        @endphp
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">محامون جدد اليوم</h3>
            <p class="text-3xl font-bold text-green-600">{{ $todayLawyers }}</p>
            <p class="text-sm text-gray-500 mt-2">تم تسجيلهم خلال اليوم الحالي</p>
        </div>
    </div>
</div>

<!-- إحصائيات الاشتراكات -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">إحصائيات الاشتراكات</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد المحامين المنتهية صلاحيتهم</h3>
            <p class="text-3xl font-bold text-red-600">{{ \App\Models\User::role('lawyer')->where('expired_at', '<=', now())->count() }}</p>
            <p class="text-sm text-gray-500 mt-2">+2 من الشهر الماضي</p>
        </div>
        @php
            $totalLawyers = \App\Models\User::role('lawyer')->count();
            $activeLawyers = \App\Models\User::role('lawyer')
                ->where('active_at', '<=', now())
                ->where('expired_at', '>=', now())
                ->count();
            $activePercentage = $totalLawyers > 0 ? round(($activeLawyers / $totalLawyers) * 100, 1) : 0;
        @endphp
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">نسبة المحامين النشطين</h3>
            <p class="text-3xl font-bold text-primary-600">{{ $activePercentage }}%</p>
            <p class="text-sm text-gray-500 mt-2">نسبة محدثة حسب الوقت الحالي</p>
        </div>
        @php
            $expiringSoon = \App\Models\User::role('lawyer')
                ->whereDate('expired_at', '>=', now())
                ->whereDate('expired_at', '<=', now()->addDays(7))
                ->count();
        @endphp
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">محامون تنتهي صلاحيتهم خلال 7 أيام</h3>
            <p class="text-3xl font-bold text-red-600">{{ $expiringSoon }}</p>
            <p class="text-sm text-gray-500 mt-2">تحقق من تجديد الاشتراك</p>
        </div>
    </div>
</div>

<!-- إحصائيات القضايا والملفات -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">إحصائيات القضايا والملفات</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">إجمالي القضايا</h3>
            <p class="text-3xl font-bold text-primary-600">156</p>
            <p class="text-sm text-gray-500 mt-2">+12% من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">القضايا النشطة</h3>
            <p class="text-3xl font-bold text-primary-600">45</p>
            <p class="text-sm text-gray-500 mt-2">+5% من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد الفولدرات</h3>
            <p class="text-3xl font-bold text-primary-600">45</p>
            <p class="text-sm text-gray-500 mt-2">+5% من الشهر الماضي</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-2">عدد الملفات</h3>
            <p class="text-3xl font-bold text-primary-600">45</p>
            <p class="text-sm text-gray-500 mt-2">+5% من الشهر الماضي</p>
        </div>
    </div>
</div>

        
        <!-- Top Lawyers Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <h3 class="text-lg font-medium mb-4">أفضل المحاميين</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-right border-b border-gray-200 dark:border-gray-700">
                            <th class="pb-3">المحامي</th>
                            <th class="pb-3">عدد القضايا</th>
                            <th class="pb-3">نسبة النجاح</th>
                            <th class="pb-3">متوسط مدة القضية</th>
                            <th class="pb-3">تقييم العملاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3">
                                <div class="flex items-center">
                                    <img src="https://via.placeholder.com/40" alt="Profile" class="w-10 h-10 rounded-full ml-3">
                                    <div>
                                        <p class="font-medium">أحمد محمد</p>
                                        <p class="text-sm text-gray-500">محامي تجاري</p>
                                    </div>
                                </div>
                            </td>
                            <td>45 قضية</td>
                            <td>85%</td>
                            <td>3 أشهر</td>
                            <td>4.8/5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    
    </main>
</div>
