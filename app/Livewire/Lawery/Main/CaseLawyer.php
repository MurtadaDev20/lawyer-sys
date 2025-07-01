<?php

namespace App\Livewire\Lawery\Main;

use App\Models\Casee;
use Livewire\Component;
use App\Models\CaseType;
use App\Models\CaseStatus;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class CaseLawyer extends Component
{
    use WithPagination;
    protected $lazy = true;
    #[Layout('components.layouts.lawyer.app')] 
    

    public $search = '';
    public $statusFilter = 'all';
    public $isModalOpen = false;
    public $caseId;
    public $customerId;

    public $name, $description, $caseType, $status, $start_date, $closed_date, $courtName, $location;

    public $statuses = [];
    public $types = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'caseType' => 'required|exists:case_types,id',
        'status' => 'required|exists:case_statuses,id',
        'start_date' => 'required|date',
        'closed_date' => 'nullable|date|after_or_equal:start_date',
        'courtName' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
    ];

    public function mount($id)
    {
        $this->statuses = CaseStatus::all();
        $this->types = CaseType::all();
        $this->customerId = $id;

    }

    public function render()
    {
        $query = Casee::query()->with(['caseStatus', 'caseType']);

        if ($this->statusFilter !== 'all') {
            $query->where('case_status_id', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.lawery.main.case-lawyer', [
            'cases' => $query->latest()->paginate(9),
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->openModal();
    }

    public function edit($id)
    {
        $case = Casee::findOrFail($id);
        $this->caseId = $case->id;
        $this->name = $case->title;
        $this->description = $case->description;
        $this->caseType = $case->caseType?->id;
        $this->status = $case->caseStatus?->id;
        $this->start_date = $case->start_date;
        $this->closed_date = $case->closed_date;
        $this->courtName = $case->court_name;
        $this->location = $case->location;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();
        $randomNumber = rand(10000, 99999);
        Casee::updateOrCreate(
            ['id' => $this->caseId],
            [
                'title' => $this->name,
                'description' => $this->description,
                'case_number' => $randomNumber,
                'case_type_id' => $this->caseType,
                'case_status_id' => $this->status,
                'lawyer_id' => Auth::id(),
                'customer_id' => $this->customerId,
                'start_date' => $this->start_date,
                'closed_date' => $this->closed_date,
                'court_name' => $this->courtName,
                'location' => $this->location,
                
                
            ]
        );

        session()->flash('message', $this->caseId ? 'تم تحديث القضية بنجاح' : 'تم إنشاء القضية بنجاح');

        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        Casee::findOrFail($id)->delete();
        session()->flash('message', 'تم حذف القضية بنجاح');
    }

    public function openModal() { $this->isModalOpen = true; }

    public function closeModal() { $this->isModalOpen = false; }

    public function resetForm()
    {
        $this->reset([
            'caseId', 'name', 'description', 'caseType', 'status', 'start_date',
            'closed_date', 'courtName', 'location'
        ]);
    }

    public function getStatus($case)
    {
        $status = $case->statusRelation?->name ?? 'غير معروف';

        return match ($status) {
            'نشط' => ['class' => 'bg-green-100 text-green-800', 'text' => 'نشط'],
            'غير مفعل' => ['class' => 'bg-red-100 text-red-800', 'text' => 'غير مفعل'],
            default => ['class' => 'bg-gray-100 text-gray-800', 'text' => $status]
        };
    }
}
