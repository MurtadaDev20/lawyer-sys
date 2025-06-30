<div>
    <main class="p-4 md:p-8 md:mr-72">
        <!-- Top Bar -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
            <h1 class="text-2xl font-bold">الأرشيف</h1>
            <button class="w-full md:w-auto px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"
                wire:click="openModal">
                إضافة مجلد جديد
            </button>
        </div>

        <!-- Search Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" wire:model.live="search"
                        placeholder="بحث عن مجلد..."
                        class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                </div>
            </div>
        </div>

        <!-- Folders Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($folders as $folder)
                <!-- Folder Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-bold">{{ $folder->name }}</h3>
                        <div class="flex space-x-2">
                            <button class="text-primary-600 hover:text-primary-700" wire:click="edit({{ $folder->id }})">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-700" wire:click="delete({{ $folder->id }})"
                                onclick="confirm('هل أنت متأكد؟') || event.stopImmediatePropagation()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ $folder->description ?? 'بدون وصف' }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ $folder->files->count() }} ملف{{ $folder->files->count() > 1 ? 'ات' : '' }}
                    </p>
                    <a href="{{ route('lawyer.file', ['id' => $folder->id]) }}"
                        class="inline-block px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        عرض الملفات
                    </a>
                </div>
            @endforeach

            
        </div>
        <div>
            @if($folders->isEmpty())
                <div class="text-center text-gray-500 dark:text-gray-400 mt-8">
                    لا توجد مجلدات لعرضها.
                </div>
            @endif
        </div>
        <!-- Pagination -->
        <div class="mt-6">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                عرض {{ $folders->count() }} من {{ $folders->total() }} مجلدات
            </p>
        </div>
        <!-- Pagination Links -->
        <div class="flex justify-center mt-4">
            
        {{ $folders->links() }}
        </div>
        <!-- Add/Edit Folder Modal -->
        @if($showModal)
            <div id="addFolderModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md">
                    <h2 class="text-xl font-bold mb-4">
                        {{ $isEdit ? 'تعديل المجلد' : 'إضافة مجلد جديد' }}
                    </h2>
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">اسم المجلد</label>
                            <input type="text" wire:model.defer="name"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">الوصف</label>
                            <textarea wire:model.defer="description" rows="3"
                                class="w-full px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600"></textarea>
                            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end space-x-2 mt-6">
                            <button type="button" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg"
                                wire:click="$set('showModal', false)">
                                إلغاء
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                                حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </main>
</div>
