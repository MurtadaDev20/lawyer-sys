<?php

namespace App\Livewire\Lawery\Main;
use ZipArchive;
use App\Models\File;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class FilePreview extends Component
{
    #[Layout('components.layouts.lawyer.app')] 
    #[Title('معاينة الملف')]
    protected $lazy = true;
    public $file;
    public $mediaItems = [];

    public function mount(File $file)
    {
        $this->file = $file;
        $this->mediaItems = $file->getMedia('documents');
    }

    public function downloadAll()
    {
        if (empty($this->mediaItems)) {
            session()->flash('error', 'لا توجد ملفات للتحميل.');
            return;
        }

        $zip = new ZipArchive;
        $zipFileName = 'file_' . $this->file->id . '_' . time() . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($this->mediaItems as $media) {
                $zip->addFile($media->getPath(), $media->file_name);
            }
            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        session()->flash('error', 'فشل إنشاء ملف ZIP.');
    }

    public function render()
    {
        return view('livewire.lawery.main.file-preview');
    }
}
