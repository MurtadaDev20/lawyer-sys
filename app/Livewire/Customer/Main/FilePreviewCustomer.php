<?php

namespace App\Livewire\Customer\Main;

use ZipArchive;
use App\Models\File;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class FilePreviewCustomer extends Component
{
    #[Layout('components.layouts.customer.app')] 
    #[Title('معاينة الملف')]
    public $file;
    public $mediaItems = [];

    public function mount(File $id)
        {
            
            $file = $id;
            $this->file = $file;
            // dd($this->file);
            $this->mediaItems = $this->file->getMedia('documents')
                            ->concat($this->file->getMedia('Casedocuments'));
        }

    public function downloadAll()
    {
        if (empty($this->mediaItems)) {
            toastr()->error('لا توجد ملفات للتحميل.');
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

        toastr()->error('فشل إنشاء ملف ZIP.');
    }
    
    public function render()
    {
        return view('livewire.customer.main.file-preview-customer');
    }
}
