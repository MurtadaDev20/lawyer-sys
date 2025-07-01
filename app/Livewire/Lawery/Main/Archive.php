<?php

namespace App\Livewire\Lawery\Main;

use App\Models\Folder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class Archive extends Component
{
    use \Livewire\WithPagination;
    #[Layout('components.layouts.lawyer.app')] 
    #[Title('الأرشيف')]

    protected $lazy = true;

    public $name, $description, $folderId;
    public $showModal = false;
    public $isEdit = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];

    public function render()
    {
        $folders = Folder::where('lawyer_id', Auth::id())
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()->paginate(9);
        return view('livewire.lawery.main.archive',
            [
                'folders' => $folders,
            ]
        );
    }

    public function openModal()
    {
        $this->reset(['name', 'description', 'folderId', 'isEdit']);
        $this->showModal = true;
    }

   public function edit($id)
    {
        $folder = Folder::findOrFail($id);
        $this->name = $folder->name;
        $this->description = $folder->description;
        $this->folderId = $folder->id;
        $this->isEdit = true;
        $this->showModal = true;
    }

     public function save()
    {
        $this->validate();

        if ($this->isEdit && $this->folderId) {
            $folder = Folder::findOrFail($this->folderId);
            $folder->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            toastr()->success('تم تحديث المجلد بنجاح.');
        } else {
            Folder::create([
                'name' => $this->name,
                'description' => $this->description,
                'lawyer_id' => Auth::id(),
            ]);
            toastr()->success('تم إنشاء المجلد بنجاح.');
        }

        $this->reset(['name', 'description', 'folderId', 'showModal', 'isEdit']);
    }

    public function delete($id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();

        session()->flash('message', 'تم حذف المجلد.');
    }
}
