<div>
    <!-- Main Content -->
    <main class="md:mr-72 p-4 md:p-8">
        <!-- Top Bar -->
        <div class="flex flex-col space-y-4 md:flex-row md:justify-between md:items-center md:mb-8 md:space-y-0">
            <h1 class="text-2xl font-bold w-full md:w-auto text-center md:text-left">إدارة القضايا</h1>
            <div class="flex space-x-2">
                {{-- <a href="{{ route('lawyer.case-lawyer') }}" wire:navigate class="btn btn-primary">الرجوع إلى قائمة القضايا</a> --}}
                <div class="w-full flex flex-col space-y-2 md:w-auto md:flex-row md:space-y-0 md:space-x-2">
                    
                    <button wire:click="openEditStatusModal"
                        class="w-full md:w-auto px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                         تعديل الحالة
                    </button>
                    <p></p>
                    <button wire:click="openAddModal"
                        class="w-full md:w-auto px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        إضافة مستندات
                    </button>
                </div>

            </div>
        </div>
        <!-- Lawyers Grid -->

                <div class="p-8 rounded-2xl shadow-lg border border-gray-800 mb-8 bg-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 17v-2a4 4 0 014-4h3m4 4v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6' /></svg>
                                </span>
                                <h2 class="text-lg font-bold text-white">تفاصيل القضية</h2>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 text-gray-200 text-sm">
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>عنوان القضية:</span><span>{{ $case->title }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>رقم القضية:</span><span>{{ $case->case_number }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>النوع:</span><span>{{ $case->caseType->name }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>الحالة:</span><span>{{ $case->caseStatus->name }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>تاريخ البدء :</span><span>{{ $case->start_date }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>تاريخ الانتهاء:</span><span>{{ $case->closed_date }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>تاريخ الإنشاء:</span><span>{{ $case->created_at->format('Y-m-d') }}</span></div>
                                <div class="flex justify-between border-b border-gray-700 pb-2"><span>اسم المحكمة:</span><span>{{ $case->court_name }}</span></div>
                                <div class="flex justify-between"><span>الموقع:</span><span>{{ $case->location }}</span></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v11a2 2 0 01-2 2z' /></svg>
                                </span>
                                <h2 class="text-lg font-bold text-white">الوصف</h2>
                            </div>
                            <div class="text-gray-200 text-sm leading-relaxed border border-gray-800 rounded-lg p-4 bg-gray-800">{{ $case->description }}</div>
                        </div>
                        {{-- <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z' /></svg>
                                </span>
                                <h2 class="text-lg font-bold text-white">المحامي المسؤول</h2>
                            </div>
                            <div class="space-y-2 text-gray-200 text-sm">
                                <div class="flex items-center gap-2"><span class="font-medium">الاسم:</span><span>{{ $case->lawyer->name }}</span></div>
                                <div class="flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a2 2 0 011.7 1l1.38 2.76a2 2 0 001.7 1H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5z' /></svg><span class="font-medium">الهاتف:</span><span>{{ $case->lawyer->phone }}</span></div>
                                <div class="flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 01-4 4H8a4 4 0 01-4-4v-1' /></svg><span class="font-medium">البريد الإلكتروني:</span><span>{{ $case->lawyer->email }}</span></div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-200' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 10a3 3 0 11-6 0 3 3 0 016 0z' /></svg>
                                </span>
                                <h2 class="text-lg font-bold text-white">العميل</h2>
                            </div>
                            <div class="space-y-2 text-gray-200 text-sm">
                                <div class="flex items-center gap-2"><span class="font-medium">الاسم:</span><span>{{ $case->customer->name }}</span></div>
                                <div class="flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a2 2 0 011.7 1l1.38 2.76a2 2 0 001.7 1H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5z' /></svg><span class="font-medium">الهاتف:</span><span>{{ $case->customer->phone }}</span></div>
                                <div class="flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a4 4 0 01-4 4H8a4 4 0 01-4-4v-1' /></svg><span class="font-medium">البريد الإلكتروني:</span><span>{{ $case->customer->email }}</span></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
        <!-- End of Lawyers Grid -->

        <div class="mt-10">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-800">
                    <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4 text-gray-400' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 5a2 2 0 012-2h3.28a2 2 0 011.7 1l1.38 2.76a2 2 0 001.7 1H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5z' /></svg>
                </span>
                <h2 class="text-lg font-bold text-white">المستندات الخاصة بالقضية</h2>
            </div>
            <ul class="space-y-3">
                {{-- @if($files->isEmpty())
                <li class="text-gray-400">لا توجد مستندات مرفقة لهذه القضية.</li>
                @endif --}}
                @foreach ($files as $file)
                <li class="flex items-center gap-4 bg-gray-900 rounded-xl px-6 py-3 border border-gray-700 shadow-sm hover:bg-gray-800 transition">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.7 1l1.38 2.76a2 2 0 001.7 1H19a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                        </svg>
                        <a href="{{ route('file.preview', $file->id) }}"  class="text-primary-300 hover:underline font-semibold text-base">
                            {{ $file->name }}
                        </a>
                    </div>
                    <span class="text-gray-400 text-xs ml-4">{{ $file->created_at->format('Y-m-d') }}</span>
                    <div class="flex gap-2 ml-auto">
                        <button wire:click="openEditModal({{ $file->id }})"  class="px-2 py-1 rounded hover:bg-primary-700 text-primary-400 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2H7v-2a2 2 0 012-2h2v2a2 2 0 01-2 2z" />
                            </svg>
                            <span class="sr-only">تعديل</span>
                        </button>
                        <button wire:click="deleteFile({{ $file->id }})" onclick="confirm('هل أنت متأكد من حذف الملف؟') || event.stopImmediatePropagation()" class="px-2 py-1 rounded hover:bg-red-700 text-red-400 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="sr-only">حذف</span>
                        </button>
                    </div>
                </li>
                @endforeach
                <div class="mt-4">
                {{ $files->links() }}
            </div>
            </ul>
            
        </div>
    </main>

    <!-- End of Main Content -->

     {{-- Add File Modal --}}
        @if($showAddModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl p-4 md:p-6 w-full max-w-md">
                <h2 class="text-lg md:text-xl font-bold mb-4">إضافة مستند جديد</h2>
               <div
                    x-data="{ progress: 0 }"
                    x-on:livewire-upload-start="progress = 0"
                    x-on:livewire-upload-finish="progress = 0"
                    x-on:livewire-upload-error="progress = 0"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                    <form wire:submit.prevent="save" class="space-y-4">
                        <!-- اسم الملف -->
                        <div>
                            <label class="block text-sm font-medium mb-1">اسم الملف</label>
                            <input wire:model.defer="name" type="text"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base">
                            @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- المستند -->
                        <div>
                            <label class="block text-sm font-medium mb-1">المستند</label>
                            <div
                                class="mt-1 flex justify-center px-4 md:px-6 pt-4 md:pt-5 pb-4 md:pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                <div class="space-y-1 text-center w-full">
                                    <input wire:model="fileUploads" multiple id="file-upload" name="file-upload" type="file"
                                        class="sr-only">
                                    <label for="file-upload"
                                        class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none inline-block px-3 py-1">
                                        رفع الملفات
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">أو اسحب الملفات هنا</span>
                                        @if ($fileUploads)
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1">
                                                {{ count($fileUploads) }} ملف{{ count($fileUploads) > 1 ? 'ات' : '' }} مرفوع
                                            </span>
                                        @endif
                                    </label>

                                    @error('fileUploads.*')
                                    <span class="text-red-600 text-xs block mt-1">{{ $message }}</span>
                                    @enderror

                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        PNG, JPG, PDF حتى 10MB
                                    </p>

                                    @if ($fileUploads)
                                        <ul class="text-left mt-2 text-xs">
                                            @foreach ($fileUploads as $upload)
                                                <li>{{ $upload->getClientOriginalName() }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <template x-if="progress > 0">
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded h-4 overflow-hidden mb-1">
                                    <div class="bg-primary-600 h-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                                </div>
                                <div class="text-right text-xs text-gray-600 dark:text-gray-400" x-text="progress + '%'"></div>
                            </div>
                        </template>

                        <!-- Actions -->
                        <div class="flex justify-end space-x-2 mt-6">
                            <button type="button"
                                    wire:click="$set('showAddModal', false)"
                                    class="px-3 md:px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm md:text-base">
                                إلغاء
                            </button>

                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="fileUploads, save"
                                class="px-3 md:px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm md:text-base flex items-center gap-2 justify-center"
                            >
                                <!-- Spinner -->
                                <svg wire:loading wire:target="fileUploads, save"
                                    class="w-4 h-4 animate-spin text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span>حفظ</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        @endif

        {{-- Edit File Modal --}}
        @if($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl p-4 md:p-6 w-full max-w-md">
                <h2 class="text-lg md:text-xl font-bold mb-4">تعديل الملف</h2>
                <div
                    x-data="{ progress: 0 }"
                    x-on:livewire-upload-start="progress = 0"
                    x-on:livewire-upload-finish="progress = 0"
                    x-on:livewire-upload-error="progress = 0"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                    <form wire:submit.prevent="update" class="space-y-4">
                        <!-- اسم الملف -->
                        <div>
                            <label class="block text-sm font-medium mb-1">اسم الملف</label>
                            <input wire:model.defer="name" type="text"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base">
                            @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- رفع ملفات جديدة -->
                        <div>
                            <label class="block text-sm font-medium mb-1">رفع ملفات جديدة</label>
                            <div class="mt-1 flex justify-center px-4 md:px-6 pt-4 md:pt-5 pb-4 md:pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                <div class="space-y-1 text-center w-full">
                                    <input wire:model="fileUploads" multiple id="file-upload-edit" name="file-upload-edit" type="file" class="sr-only">
                                    <label for="file-upload-edit"
                                        class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none inline-block px-3 py-1">
                                        رفع ملفات جديدة (متعدد)
                                    </label>
                                    @error('fileUploads.*') <span class="text-red-600 text-xs block mt-1">{{ $message }}</span> @enderror

                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        PNG, JPG, PDF حتى 10MB
                                    </p>

                                    @if ($fileUploads)
                                        <ul class="text-left mt-2 text-xs">
                                            @foreach ($fileUploads as $upload)
                                                <li>{{ $upload->getClientOriginalName() }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <template x-if="progress > 0">
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded h-4 overflow-hidden mb-1">
                                    <div class="bg-primary-600 h-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                                </div>
                                <div class="text-right text-xs text-gray-600 dark:text-gray-400" x-text="progress + '%'"></div>
                            </div>
                        </template>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-2 mt-6">
                            <button type="button"
                                    wire:click="$set('showEditModal', false)"
                                    class="px-3 md:px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm md:text-base">
                                إلغاء
                            </button>

                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="fileUploads, update"
                                class="px-3 md:px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm md:text-base flex items-center justify-center gap-2"
                            >
                                <!-- Spinner -->
                                <svg wire:loading wire:target="fileUploads, update"
                                    class="w-4 h-4 animate-spin text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span>تحديث</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Edit Status Modal --}}
        @if($showEditStatusModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl p-4 md:p-6 w-full max-w-md">
                <h2 class="text-lg md:text-xl font-bold mb-4">تعديل حالة القضية</h2>
                <form wire:submit.prevent="updateStatus({{ $case->id }})" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">الحالة الجديدة</label>
                        <select wire:model.lazy="statusCase" class="w-full md:w-auto px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                            <option value="all">كل الحالات</option>
                            @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('newStatus') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" wire:click="$set('showEditStatusModal', false)" class="px-3 md:px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm md:text-base">
                            إلغاء
                        </button>
                        <p></p>
                        <button type="submit" class="px-3 md:px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm md:text-base">
                            حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif


</div>
