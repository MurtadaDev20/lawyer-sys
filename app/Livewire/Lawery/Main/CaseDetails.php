<?php

namespace App\Livewire\Lawery\Main;

use App\Models\File;
use App\Models\Casee;
use App\Traits\SendsWhatsappNotification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class CaseDetails extends Component
{
    use WithFileUploads , SendsWhatsappNotification;
    #[Layout('components.layouts.lawyer.app')] 
    #[Title('تفاصيل القضية')]

    public $caseId ,
           $statuses = [],
           $status = 'all',
           $name,
           $customer_case_id,
           $statusCase = 'all';

    
    public $fileUploads = [];
    public $fileIdForEdit = null;

    public $showAddModal = false;
    public $showEditModal = false;
    public $showEditStatusModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'fileUploads.*' => 'file|mimes:pdf,png,jpg,jpeg|max:10240', // max 10MB
    ];

    public function mount($id)
    {
        $this->caseId = $id;
        $this->statuses = \App\Models\CaseStatus::all();
        $this->customer_case_id = Casee::where('id', $id)
            ->where('lawyer_id', Auth::id())->first();
    }
    
    public function render()
    {
        $files = File::where('case_id', $this->caseId)
            ->where('lawyer_id', Auth::id())
            ->paginate(10);

        $case = Casee::with(['lawyer', 'customer', 'caseType', 'caseStatus'])
            ->where('id', $this->caseId)
            ->where('lawyer_id', Auth::id())
            ->firstOrFail();
        return view('livewire.lawery.main.case-details', [
            'case' => $case,
            'files' => $files,
        ]);
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function openEditStatusModal()
    {
        $this->showEditStatusModal = true;
    }

    public function openEditModal($id)
    {
        
        $this->showEditModal = true;
        $file = File::findOrFail($id);
        $this->fileIdForEdit = $file->id;
        $this->name = $file->name;
    }

    public function resetForm()
    {
        $this->reset(['name', 'fileUploads', 'fileIdForEdit']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $file = File::create([
            'name' => $this->name,
            'case_id' => $this->caseId,
            'lawyer_id' => Auth::id(),
            'customer_id' => $this->customer_case_id->customer_id,
        ]);

        if ($this->fileUploads) {
            foreach ($this->fileUploads as $upload) {
                $file->addMedia($upload->getRealPath())
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('Casedocuments');
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
            'fileUploads.*' => 'file|mimes:pdf,png,jpg,jpeg|max:10240',
        ]);

        $file = File::findOrFail($this->fileIdForEdit);
        $file->update([
            'name' => $this->name,
        ]);

        if ($this->fileUploads) {
            // Add new media files if uploaded
            foreach ($this->fileUploads as $upload) {
                $file->addMedia($upload->getRealPath())
                    ->usingFileName($upload->getClientOriginalName())
                    ->toMediaCollection('Casedocuments');
            }
        }

        $this->resetForm();
        $this->showEditModal = false;
        toastr()->success('تم تحديث الملف بنجاح');
    }

    public function deleteFile($id)
    {
        $file = File::findOrFail($id);
        $file->delete();
        toastr()->success('تم حذف الملف بنجاح');
    }

    public function updateStatus($caseId)
    {
        $this->validate([
            'statusCase' => 'required|exists:case_statuses,id',
        ]);

        $case = Casee::with(['customer', 'caseStatus'])->findOrFail($caseId);
        $case->case_status_id = $this->statusCase;
        $case->save();

        $case->load('caseStatus');
        $this->showEditStatusModal = false;
        toastr()->success('تم تحديث حالة القضية بنجاح');

        if($case)
        {
            if ($case->customer && $case->customer->phone) 
            {
                $url = config('app.url') . '/lawyer/files/preview/' . $case->id;

                $message = <<<EOT
                مرحبًا {$case->customer->name} 👋

                لقد تم تحديث الحالة الخاصة بالقضية: *"{$case->title}"*  
                🔄 الحالة الجديدة: *"{$case->caseStatus->name}"*

                📎 للاطلاع على تفاصيل القضية، اضغط على الرابط التالي:

                {$url}
                EOT;

                        $this->sendWhatsappMessage($case->customer, $message);
            }
        }
        
    }
}
