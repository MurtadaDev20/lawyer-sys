<div>
    <!-- Main Content -->
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Top Bar -->
        <div class="flex flex-col space-y-4 md:flex-row md:justify-between md:items-center md:mb-8 md:space-y-0">
            <h1 class="text-2xl font-bold w-full md:w-auto text-center md:text-left">إدارة الضايا</h1>
            <div class="w-full flex flex-col space-y-2 md:w-auto md:flex-row md:space-y-0 md:space-x-2">
                <select wire:model.lazy="statusFilter" class="w-full md:w-auto px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                    <option value="all">كل الحالات</option>
                    @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
                <input 
                    type="text" 
                    wire:model.live="search"
                    placeholder="بحث..."
                    class="w-full md:w-auto px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                >
                <button 
                    wire:click="create"
                    class="w-full md:w-auto px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
                >
                    إضافة قضية جديدة
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <!-- Lawyers Grid -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 md:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($cases as $case)
    @php
        $status = $this->getStatus($case);
    @endphp
    <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-600">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center">
                <p>العنوان:  </p>
                <div>
                    <h3 class="font-medium text-lg">{{ $case->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $case->courtName }}</p>
                </div>
            </div>
            <span class="px-2 py-1 rounded-full text-sm ">
                {{ $case->caseStatus?->name ?? 'غير محدد' }}
            </span>
        </div>

        <div class="space-y-3 text-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path d="M16 8a6 6 0 00-12 0v4a6 6 0 0012 0V8z"></path>
                    <path d="M12 14v7m0 0H9m3 0h3"></path>
                </svg>
                <span>نوع القضية: {{ $case->caseType?->name ?? 'غير محدد' }}</span>
            </div>

            <div class="flex items-center">
                <svg class="w-5 h-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.243-4.243a8 8 0 1111.313 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>العنوان: {{ $case->location ?? 'غير محدد' }}</span>
            </div>

            <div class="flex items-center">
                <svg class="w-5 h-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>تاريخ البدء: {{ \Carbon\Carbon::parse($case->start_date)->format('Y-m-d') }}</span>
            </div>

            @if ($case->closed_date)
                <div class="flex items-center">
                    <svg class="w-5 h-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>تاريخ الإغلاق: {{ \Carbon\Carbon::parse($case->closed_date)->format('Y-m-d') }}</span>
                </div>
            @endif
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-2">
            <a href="{{ route('lawyer.case-details', ['id' => $case->id]) }}"
               wire:navigate
               class="text-primary-600 hover:text-primary-700 px-3 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                تفاصيل
            </a>
            <button 
                wire:click="edit({{ $case->id }})"
                class="text-primary-600 hover:text-primary-700 px-3 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.232 5.232l3.536 3.536M9 13l6.293-6.293a1 1 0 011.414 0L21 9M16 21H4a1 1 0 01-1-1v-9a1 1 0 011-1h12a1 1 0 011 1v9a1 1 0 01-1 1z"></path>
                </svg>
                تعديل
            </button>
            <button 
                wire:click="delete({{ $case->id }})"
                onclick="confirm('هل أنت متأكد من حذف هذه القضية؟') || event.stopImmediatePropagation()"
                class="text-red-600 hover:text-red-700 px-3 py-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a2 2 0 012 2v2H8V5a2 2 0 012-2z"></path>
                </svg>
                حذف
            </button>
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

        <!-- Add/Edit Lawyer Modal -->
        <div x-show="$wire.isModalOpen" x-cloak 
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
        >
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 md:p-6 w-full max-w-md"
                 x-show="$wire.isModalOpen"
                 @click.away="$wire.closeModal()"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
            >
                <h2 class="text-xl font-bold mb-4">
                    {{ $caseId ? 'تعديل بيانات القضية' : 'إضافة قضية جديدة' }}
                </h2>
                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">عنوان القضية</label>
                        <input type="text" wire:model="name" 
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">وصف القضية</label>
                        <input type="text" wire:model="description" 
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">نوع القضية</label>
                        <select wire:model="caseType"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                            <option value="">اختر النوع</option>
                            @foreach($types  as $caseType)
                                <option value="{{ $caseType->id }}">{{ $caseType->name }}</option>
                            @endforeach
                        </select>
                        @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">حالة القضية</label>
                        <select wire:model="status"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                            <option value="">اختر الحالة</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">تاريخ البدء</label>
                        <input type="date" wire:model="start_date"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">تاريخ الانتهاء</label>
                        <input type="date" wire:model="closed_date"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('closed_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">اسم المحكمة</label>
                        <input type="text" wire:model="courtName" 
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('courtName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">العنوان</label>
                        <input type="text" wire:model="location" 
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg">
                            إلغاء
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                            حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>