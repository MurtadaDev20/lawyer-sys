<div class="p-4 md:p-8 md:mr-72">
    <h1 class="text-2xl font-bold mb-6">معاينة ملفات: {{ $file->name }}</h1>

    <div class="mb-4">
        <button wire:click="downloadAll" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
            تحميل جميع الملفات
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        @foreach ($mediaItems as $media)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                <h3 class="font-semibold mb-2 text-sm">{{ $media->file_name }}</h3>

                @if (Str::contains($media->mime_type, 'image'))
                    <img src="{{ $media->getUrl() }}" alt="{{ $media->file_name }}" class="rounded-lg max-h-48 w-full object-contain" />
                @elseif ($media->mime_type === 'application/pdf')
                    <embed src="{{ $media->getUrl() }}" type="application/pdf" width="100%" height="300px" />
                @else
                    <p class="text-gray-500 text-sm">لا يمكن معاينة هذا النوع من الملفات.</p>
                @endif

                <a href="{{ $media->getUrl() }}" target="_blank" class="block mt-2 text-sm text-primary-600 hover:underline">
                    تحميل هذا الملف
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <a href="{{ route('lawyer.file', $file->folder_id) }}" class="text-primary-600 hover:underline">
            ← العودة إلى الملفات
        </a>
    </div>
</div>
