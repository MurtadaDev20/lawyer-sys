<?php

namespace App\Livewire\Lawery\Main;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\File as ModelsFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class File extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.lawyer.app')] 
    #[Title('إدارة الملفات')]
    protected $lazy = true;

    public $folderId;
    public $files;
    public $search = '';

    public $name, $number, $description;
    public $fileUploads = [];
    public $fileIdForEdit = null;

    public $showAddModal = false;
    public $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'number' => 'required|numeric|unique:files,number',
        'description' => 'nullable|string',
        'fileUploads.*' => 'file|mimes:pdf,png,jpg,jpeg|max:10240', // max 10MB
    ];

    public function mount($id)
    {
        $this->folderId = $id;
    }

    public function render()
    {
        $this->files = ModelsFile::where('folder_id', $this->folderId)
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('number', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->with(['lawyer','folder','casee','customer','media'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.lawery.main.file');
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function openEditModal($id)
    {
        $file = ModelsFile::findOrFail($id);
        $this->fileIdForEdit = $file->id;
        $this->name = $file->name;
        $this->number = $file->number;
        $this->description = $file->description;
        $this->showEditModal = true;
    }

    public function resetForm()
    {
        $this->reset(['name', 'number', 'description', 'fileUploads', 'fileIdForEdit']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $file = ModelsFile::create([
            'name' => $this->name,
            'number' => $this->number,
            'description' => $this->description,
            'folder_id' => $this->folderId,
            'lawyer_id' => Auth::id(),
        ]);

        if ($this->fileUploads) {
            foreach ($this->fileUploads as $upload) {
                $file->addMedia($upload->getRealPath())
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('documents');
            }
        }

        $this->resetForm();
        $this->showAddModal = false;

        toastr()->success('تم إضافة الملف بنجاح');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|numeric|unique:files,number,' . $this->fileIdForEdit,
            'description' => 'nullable|string',
            'fileUploads.*' => 'file|mimes:pdf,png,jpg,jpeg|max:10240',
        ]);

        $file = ModelsFile::findOrFail($this->fileIdForEdit);
        $file->update([
            'name' => $this->name,
            'number' => $this->number,
            'description' => $this->description,
        ]);

        if ($this->fileUploads) {
            // Add new media files if uploaded
            foreach ($this->fileUploads as $upload) {
                $file->addMedia($upload->getRealPath())
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('documents');
            }
        }

        $this->resetForm();
        $this->showEditModal = false;

        session()->flash('message', 'تم تحديث الملف بنجاح');
    }

    public function delete($id)
    {
        $file = ModelsFile::findOrFail($id);
        // Delete all media files attached
        $file->clearMediaCollection('documents');
        $file->delete();

        session()->flash('message', 'تم حذف الملف بنجاح');
    }

    // public function download($id, $mediaId)
    // {
    //     $file = ModelsFile::findOrFail($id);
    //     $media = $file->getMedia('documents')->where('id', $mediaId)->first();

    //     if ($media && Storage::disk($media->disk)->exists($media->getPath())) {
    //         return response()->download($media->getPath(), $media->file_name);
    //     }

    //     toastr()->error('الملف غير موجود أو تم حذفه');
    // }
}