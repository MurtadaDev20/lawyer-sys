<div>
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl font-bold">لوحة التحكم الخاصة بالعميل</h1>
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
            <h1 class="text-2xl font-bold mb-2 dark:text-white">مرحباً،  {{Auth::user()->name}}</h1>
            <p class="text-gray-600 dark:text-gray-400">هذه لوحة تحكم العميل حيث يمكنك إدارة القضايا الخاصة بك</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Total Lawyers --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 dark:text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <span class="text-sm text-green-600 dark:text-green-400">+12% هذا الشهر</span>
        </div>
        <h3 class="text-2xl font-bold mb-1">{{ \App\Models\CustomerLawyer::where('customer_id',Auth::id())->count() }}</h3>
        <p class="text-gray-600 dark:text-gray-400">إجمالي عدد المحامين المشترك معهم</p>
    </div>

    {{-- All Cases --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 dark:text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </div>
            <span class="text-sm text-blue-600 dark:text-blue-400">+5% هذا الشهر</span>
        </div>
        <h3 class="text-2xl font-bold mb-1">{{ \App\Models\Casee::where('customer_id',Auth::id())->count() ?? 0 }}</h3>
        <p class="text-gray-600 dark:text-gray-400">جميع القضايا</p>
    </div>

    {{-- Waiting Cases --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 dark:text-white" >
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-sm text-purple-600 dark:text-purple-400">+8% هذا الشهر</span>
        </div>
        <h3 class="text-2xl font-bold mb-1">{{ \App\Models\Casee::where('case_status_id',1)->where('customer_id',Auth::id())->count() ?? 0 }}</h3>
        <p class="text-gray-600 dark:text-gray-400">قضايا قيد الانتظار</p>
    </div>

    {{-- Under Review --}}
    @php $statuses = [
        ['id' => 2, 'title' => 'قضايا قيد المراجعة', 'icon' => 'M7 8h10M7 12h4m5.5 2.5l2 2M21 21l-2-2', 'color' => 'yellow'],
        ['id' => 3, 'title' => 'قضايا تمت المتابعة', 'icon' => 'M9 12l2 2 4-4M12 22a10 10 0 100-20 10 10 0 000 20z', 'color' => 'green'],
        ['id' => 4, 'title' => 'قضايا مغلقة', 'icon' => 'M12 15v2m0-10v2m6 2a6 6 0 00-12 0v2h12v-2z', 'color' => 'gray'],
        ['id' => 5, 'title' => 'قضايا مرفوضة', 'icon' => 'M12 12l3 3m-3-3l-3-3m3 3l3-3m-3 3l-3 3M12 22a10 10 0 100-20', 'color' => 'red'],
        ['id' => 6, 'title' => 'قضايا محالة لمحكمة أخرى', 'icon' => 'M13 17l5-5m0 0l-5-5m5 5H6', 'color' => 'blue'],
        ['id' => 7, 'title' => 'قضايا مؤجلة', 'icon' => 'M10 9v6m4-6v6M12 22a10 10 0 100-20', 'color' => 'indigo'],
        ['id' => 8, 'title' => 'قضايا قيد التنفيذ', 'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.868v4.264a1 1 0 001.555.832l3.197-2.132z', 'color' => 'orange'],
    ]; @endphp

    @foreach($statuses as $status)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 dark:text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-{{ $status['color'] }}-100 dark:bg-{{ $status['color'] }}-900 rounded-lg">
                <svg class="w-6 h-6 text-{{ $status['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $status['icon'] }}" />
                </svg>
            </div>
            <span class="text-sm text-{{ $status['color'] }}-600 dark:text-{{ $status['color'] }}-400">+15% هذا الشهر</span>
        </div>
        <h3 class="text-2xl font-bold mb-1">{{ \App\Models\Casee::where('case_status_id', $status['id'])->where('customer_id', Auth::id())->count() ?? 0 }}</h3>
        <p class="text-gray-600 dark:text-gray-400">{{ $status['title'] }}</p>
    </div>
    @endforeach
</div>


       
    </main>
</div>
