<div>
    <!-- Main Content -->
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Top Bar -->
        <div class="flex flex-col space-y-4 md:flex-row md:justify-between md:items-center md:mb-8 md:space-y-0 mb-4">
            <h1 class="text-2xl font-bold w-full md:w-auto text-center md:text-left">إدارة الضايا</h1>
            <div class="w-full flex flex-col space-y-2 md:w-auto md:flex-row md:space-y-0 md:space-x-2">
                <select wire:model.lazy="statusFilter" class="w-full md:w-auto px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="all">كل الحالات</option>
                    @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
                <p></p>
                <input 
                    type="text" 
                    wire:model.live="search"
                    placeholder="بحث..."
                    class="w-full md:w-auto px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 mb-1"
                >
                
            </div>
        </div>

        <!-- Lawyers Grid -->

    <!-- Lawyers Grid -->
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($cases as $case)
                    @php
    $statusColors = [
        1 => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
        2 => 'bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
        3 => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
        4 => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100',
        5 => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100',
        6 => 'bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-100',
        7 => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-700 dark:text-indigo-100',
        8 => 'bg-orange-100 text-orange-800 dark:bg-orange-700 dark:text-orange-100',
    ];
    $statusClass = $statusColors[$case->case_status_id] ?? 'bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-white';
@endphp

            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-600">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">العنوان:</p>
                        <h3 class="font-medium text-lg dark:text-white">{{ $case->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 ">{{ $case->courtName }}</p>
                    </div>
                    <span class="px-3 py-1 font-medium  rounded-full text-sm {{ $statusClass }}">
                        {{ $case->caseStatus?->name ?? 'غير محدد' }}
                    </span>
                </div>

                <div class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                    <!-- Lawyer -->
                    <div class="flex items-center">
                        <svg class="w-5 h-5 ml-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>المحامي: {{ $case->lawyer?->name ?? 'غير محدد' }}</span>
                    </div>

                    <!-- Case Type -->
                    <div class="flex items-center">
                        <svg class="w-5 h-5 ml-2 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17v-2a4 4 0 014-4h6M9 7h.01M12 7h.01M15 7h.01M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2z" />
                        </svg>
                        <span>نوع القضية: {{ $case->caseType?->name ?? 'غير محدد' }}</span>
                    </div>

                    <!-- Location -->
                    <div class="flex items-center">
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>العنوان: {{ $case->location ?? 'غير محدد' }}</span>
                    </div>

                    <!-- Start Date -->
                    <div class="flex items-center">
                        <svg class="w-5 h-5 ml-2 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>تاريخ البدء: {{ \Carbon\Carbon::parse($case->start_date)->format('Y-m-d') }}</span>
                    </div>

                    <!-- Closed Date -->
                    @if ($case->closed_date)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 ml-2 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>تاريخ الإغلاق: {{ \Carbon\Carbon::parse($case->closed_date)->format('Y-m-d') }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 flex justify-end">
                    <a href="{{ route('customer.case-details', ['id' => $case->id]) }}"
                        wire:navigate
                        class="text-primary-600 hover:text-primary-700 px-3 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        تفاصيل
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8">
                <p class="text-gray-500 dark:text-gray-400">لا توجد قضايا بعد</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $cases->links() }}
    </div>
</div>


        
    </main>
</div>