<div>
    <main class="p-4 md:p-8 md:mr-72">

        <!-- Top Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-xl md:text-2xl font-bold">قضايا تجارية</h1>
                <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">{{ $files->count() }} ملف</p>
            </div>
            <button wire:click="openAddModal" class="w-full md:w-auto px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                إضافة ملف جديد
            </button>
        </div>

        <!-- Search Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-md p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" wire:model.debounce.300ms="search" placeholder="بحث عن ملف..." class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base">
                </div>
                <!-- You can add date filters here if you want -->
            </div>
        </div>

        <!-- Files Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach ($files as $file)
            <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl shadow-md p-4 md:p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-base md:text-lg font-bold">{{ $file->name }}</h3>
                        <p class="text-xs md:text-sm text-gray-500">تم الإضافة: {{ $file->created_at->format('Y/m/d') }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="openEditModal({{ $file->id }})" class="text-primary-600 hover:text-primary-700 p-1" title="تعديل">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button wire:click="delete({{ $file->id }})" onclick="confirm('هل أنت متأكد من حذف الملف؟') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-700 p-1" title="حذف">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center m-2">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs md:text-sm text-gray-500">عدد الملفات: {{ $file->getMedia('documents')->count() }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <a href="{{ route('file.preview', $file->id) }}" wire:navigate class="text-sm md:text-base text-primary-600 hover:text-primary-700 px-2 py-1 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/50 transition-colors">
                        معاينة
                    </a>
                    
                </div>
            </div>
            @endforeach
        </div>

        {{-- Add File Modal --}}
        @if($showAddModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white dark:bg-gray-800 rounded-xl md:rounded-2xl p-4 md:p-6 w-full max-w-md">
                <h2 class="text-lg md:text-xl font-bold mb-4">إضافة ملف جديد</h2>
                <div
                    x-data="{ progress: 0 }"
                    x-on:livewire-upload-start="progress = 0"
                    x-on:livewire-upload-finish="progress = 0"
                    x-on:livewire-upload-error="progress = 0"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">اسم الملف</label>
                            <input wire:model.defer="name" type="text"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base">
                            @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">رقم الملف</label>
                            <input wire:model.defer="number" type="number"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base">
                            @error('number') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">الوصف</label>
                            <textarea wire:model.defer="description"
                                    class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base"
                                    rows="3"></textarea>
                            @error('description') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">الملف</label>
                            <div
                                class="mt-1 flex justify-center px-4 md:px-6 pt-4 md:pt-5 pb-4 md:pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                <div class="space-y-1 text-center w-full">
                                    <input wire:model="fileUploads" multiple id="file-upload" name="file-upload" type="file"
                                        class="sr-only">
                                    <label for="file-upload"
                                        class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none inline-block px-3 py-1">
                                        رفع ملف (متعدد)
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

                        <!-- Upload Progress Bar -->
                        <template x-if="progress > 0">
                            <div class="w-full mt-4">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded h-4 overflow-hidden mb-1">
                                    <div class="bg-primary-600 h-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                                </div>
                                <div class="text-right text-xs text-gray-600 dark:text-gray-400" x-text="progress + '%'"></div>
                            </div>
                        </template>

                        <div class="flex justify-end space-x-2 mt-6">
                            <button type="button"
                                    wire:click="$set('showAddModal', false)"
                                    class="px-3 md:px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg text-sm md:text-base">
                                إلغاء
                            </button>

                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    wire:target="fileUploads, save"
                                    class="px-3 md:px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm md:text-base flex items-center justify-center gap-2">
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

                        <!-- رقم الملف -->
                        <div>
                            <label class="block text-sm font-medium mb-1">رقم الملف</label>
                            <input wire:model.defer="number" type="number"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base">
                            @error('number') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- الوصف -->
                        <div>
                            <label class="block text-sm font-medium mb-1">الوصف</label>
                            <textarea wire:model.defer="description"
                                    class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm md:text-base"
                                    rows="3"></textarea>
                            @error('description') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- رفع ملفات جديدة -->
                        <div>
                            <label class="block text-sm font-medium mb-1">رفع ملفات جديدة</label>
                            <div
                                class="mt-1 flex justify-center px-4 md:px-6 pt-4 md:pt-5 pb-4 md:pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                <div class="space-y-1 text-center w-full">
                                    <input wire:model="fileUploads" multiple id="file-upload-edit" name="file-upload-edit" type="file"
                                        class="sr-only">
                                    <label for="file-upload-edit"
                                        class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none inline-block px-3 py-1">
                                        رفع ملفات جديدة (متعدد)
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

    </main>
</div>
