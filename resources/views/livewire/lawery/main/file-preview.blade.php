<div class="p-4 md:p-8 md:mr-72">
    <h1 class="text-2xl font-bold mb-6">معاينة ملفات: {{ $file->name }}</h1>

    <div class="mb-4">
        {{-- <button wire:click="downloadAll" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
            تحميل جميع الملفات
        </button> --}}

            {{-- ملاحظة + زر تحميل الكل --}}
            @if ($mediaItems->count())
                <div class="mt-6">
                    
                    <button onclick="downloadAllFiles()" 
                            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        تحميل كل الملفات
                    </button>
                    <p class="text-gray-500 text-sm mb-2">
                        عند الضغط على "تحميل كل الملفات"، سيتم فتح كل ملف في تبويب جديد أو تحميله حسب إعدادات المتصفح.
                    </p>
                </div>
            @endif
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
      
    @foreach ($mediaItems as $media)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <h3 class="font-semibold mb-2 text-sm">{{ $media->file_name }}</h3>

            {{-- عرض الصور --}}
            @if (Str::contains($media->mime_type, 'image'))
                <img src="{{ $media->getUrl() }}" alt="{{ $media->file_name }}"
                    class="rounded-lg max-h-48 w-full object-contain  border-primary-400 shadow mb-2" />
                <span class="inline-block bg-primary-50 text-primary-700 dark:bg-primary-900 dark:text-primary-200 px-3 py-1 rounded-full text-xs font-bold shadow-sm mb-2">
                    الحجم: {{ $media->human_readable_size }}
                </span>

            {{-- عرض ملفات PDF --}}
            @elseif ($media->mime_type === 'application/pdf')
                <embed src="{{ $media->getUrl() }}" type="application/pdf" width="100%" height="300px" class="rounded border shadow mb-2" />

            {{-- ملف غير قابل للمعاينة --}}
            @else
                <p class="text-gray-500 text-sm">لا يمكن معاينة هذا النوع من الملفات.</p>
            @endif

            {{-- رابط تحميل فردي --}}
            <a href="{{ $media->getUrl() }}" target="_blank" download
                class="block mt-2 text-sm text-primary-600 hover:underline">
                تحميل هذا الملف
            </a>
        </div>
    @endforeach
</div>



{{-- سكربت تحميل كل الملفات --}}

    </div>

    {{-- <div class="mt-6">
        <a href="{{ route('lawyer.file', $file->folder_id) }}" class="text-primary-600 hover:underline">
            ← العودة إلى الملفات
        </a>
    </div> --}}
    <script>
    function downloadAllFiles() {
        const urls = @json($mediaItems->map(fn($m) => $m->getFullUrl()));
        urls.forEach(url => {
            const a = document.createElement('a');
            a.href = url;
            a.download = '';
            a.target = '_blank';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    }
</script>
</div>
