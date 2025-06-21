<div>
    <!-- Main Content -->
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Top Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <h1 class="text-2xl font-bold">إدارة العملاء</h1>
            <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                <select wire:model.lazy="lawyerFilter" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 mx-4">
                    <option value="">اختر محامي</option>
                    @foreach($lawyers as $lawyer)
                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                    @endforeach
                </select>
                <select wire:model.lazy="statusFilter" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 mx-4 ">
                    <option value="all">الكل</option>
                    <option value="active">نشط</option>
                    <option value="expired">منتهي</option>
                    <option value="not_active">غير مفعل</option>
                </select>
                <input 
                    type="text" 
                    wire:model.debounce.500ms="search"
                    placeholder="بحث..."
                    class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                >
                <button 
                    wire:click="create"
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
                >
                    إضافة عميل جديد
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
                @forelse ($customers as $customer)
                    @php
                        $status = $this->getStatus($customer);
                    @endphp
                    <div class="bg-white dark:bg-gray-700 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=random" 
                                     alt="Profile" 
                                     class="w-12 h-12 rounded-full ml-3">
                                <div>
                                    <h3 class="font-medium text-lg">{{ $customer->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $customer->email }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded-full text-sm {{ $status['class'] }}">
                                {{ $status['text'] }}
                            </span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <svg class="h-5 w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $customer->address }}</span>
                            </div>
                            <div class="flex items-center text-xs md:text-sm">
                                <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ $customer->phone }}</span>
                            </div>
                            <div class="flex items-center text-xs md:text-sm">
                                <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>عميل المحامي - {{ $customer->lawyer->name ?? 'غير مرتبط بمحام' }}</span>
                            </div>
                            <div class="flex items-center text-xs md:text-sm">
                                <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>فعال من: {{ \Carbon\Carbon::parse($customer->active_at)->format('Y-m-d') }}</span>
                            </div>
                            <div class="flex items-center text-xs md:text-sm">
                                <svg class="h-4 w-4 md:h-5 md:w-5 ml-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>ينتهي في: {{ \Carbon\Carbon::parse($customer->expired_at)->format('Y-m-d') }}</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-2">
                            <button 
                                wire:click="edit({{ $customer->id }})"
                                class="text-primary-600 hover:text-primary-700 px-3 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors"
                            >
                                تعديل
                            </button>
                            <button 
                                wire:click="delete({{ $customer->id }})"
                                onclick="confirm('هل أنت متأكد من حذف هذا المحامي؟') || event.stopImmediatePropagation()"
                                class="text-red-600 hover:text-red-700 px-3 py-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors"
                            >
                                حذف
                            </button>
                            @if(($customer->is_active))
                                <button 
                                    wire:click="deactivate({{ $customer->id }})"
                                    class="text-yellow-600 hover:text-yellow-700 px-3 py-1 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/50 transition-colors"
                                >
                                    إلغاء التفعيل
                                </button>
                            @else
                                <button 
                                    wire:click="activate({{ $customer->id }})"
                                    class="text-green-600 hover:text-green-700 px-3 py-1 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/50 transition-colors"
                                >
                                    تفعيل
                                </button>
                            @endif
                           
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">لا يوجد عملاء مسجلون</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-4">
                {{ $customers->links() }}
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
                    {{ $customerId ? 'تعديل بيانات المحامي' : 'إضافة محامي جديد' }}
                </h2>
                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">الاسم الكامل</label>
                        <input type="text" wire:model="name" 
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
                        <input type="email" wire:model="email"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">رقم الهاتف</label>
                        <input type="tel" wire:model="phone"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">المحامي</label>
                        <select wire:model="lower_id" class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                            <option value="">اختر محامي</option>
                            @foreach($lawyers as $lawyer)
                                <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                            @endforeach
                        </select>
                        @error('lower_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">المدينة</label>
                        <select wire:model="address"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                            <option value="">اختر المدينة</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                        @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">تاريخ البدء</label>
                        <input type="date" wire:model="active_at"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('active_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">تاريخ الانتهاء</label>
                        <input type="date" wire:model="expired_at"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('expired_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">كلمة المرور</label>
                        <input type="password" wire:model="password"
                               class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        @if($customerId)
                            <p class="text-xs text-gray-500 mt-1">اترك الحقل فارغاً إذا كنت لا تريد تغيير كلمة المرور</p>
                        @endif
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