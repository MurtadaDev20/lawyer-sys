<div>
    <!-- Main Content -->
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Top Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <h1 class="text-2xl font-bold">التقارير والإحصائيات</h1>
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 w-full md:w-auto">
                <select class="px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                    <option>آخر 7 أيام</option>
                    <option>آخر 30 يوم</option>
                    <option>آخر 3 أشهر</option>
                    <option>آخر سنة</option>
                </select>
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    تصدير التقرير
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
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
                <h3 class="text-lg font-medium mb-2">عدد العملاء</h3>
                <p class="text-3xl font-bold text-primary-600">{{ \App\Models\User::role('Customer')->count() }}</p>
                <p class="text-sm text-gray-500 mt-2">+8% من الشهر الماضي</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
                <h3 class="text-lg font-medium mb-2">عدد المحاميين</h3>
                <p class="text-3xl font-bold text-primary-600">{{ \App\Models\User::role('lawyer')->count() }}</p>
                <p class="text-sm text-gray-500 mt-2">+2 من الشهر الماضي</p>
            </div>
        </div>

        <!-- Charts -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
                <h3 class="text-lg font-medium mb-4">القضايا حسب النوع</h3>
                <canvas id="casesByTypeChart"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
                <h3 class="text-lg font-medium mb-4">القضايا عبر الزمن</h3>
                <canvas id="casesOverTimeChart"></canvas>
            </div>
        </div> --}}

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

        <!-- Reports Grid -->
        <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-md p-4 md:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Report Card -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm p-4 md:p-6 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-base md:text-lg font-medium">تقرير القضايا الشهرية</h3>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">15/03/2024</p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs md:text-sm bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                            PDF
                        </span>
                    </div>
                    <div class="space-y-2 md:space-y-3">
                        <div class="flex items-center text-xs md:text-sm">
                            <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>حجم الملف: 2.5 MB</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm">
                            <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>تاريخ الإنشاء: 15/03/2024</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm">
                            <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>بواسطة: محمد علي</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-2">
                        <button class="text-xs md:text-sm text-primary-600 hover:text-primary-700 px-2 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors">
                            تحميل
                        </button>
                        <button class="text-xs md:text-sm text-primary-600 hover:text-primary-700 px-2 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors">
                            مشاركة
                        </button>
                        <button class="text-xs md:text-sm text-red-600 hover:text-red-700 px-2 py-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors">
                            حذف
                        </button>
                    </div>
                </div>

                <!-- Add More Report Cards Here -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm p-4 md:p-6 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-base md:text-lg font-medium">تقرير العملاء</h3>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">10/03/2024</p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs md:text-sm bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                            PDF
                        </span>
                    </div>
                    <div class="space-y-2 md:space-y-3">
                        <div class="flex items-center text-xs md:text-sm">
                            <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>حجم الملف: 1.8 MB</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm">
                            <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>تاريخ الإنشاء: 10/03/2024</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm">
                            <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>بواسطة: أحمد محمد</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-2">
                        <button class="text-xs md:text-sm text-primary-600 hover:text-primary-700 px-2 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors">
                            تحميل
                        </button>
                        <button class="text-xs md:text-sm text-primary-600 hover:text-primary-700 px-2 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors">
                            مشاركة
                        </button>
                        <button class="text-xs md:text-sm text-red-600 hover:text-red-700 px-2 py-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors">
                            حذف
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
