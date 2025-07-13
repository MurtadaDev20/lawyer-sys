<?php

namespace App\Livewire\Customer\Main;

use App\Models\Casee;
use App\Models\CaseStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CasessCustomer extends Component
{
    use WithPagination;

    #[Layout('components.layouts.customer.app')]
    public string $statusFilter = 'all';
    public string $search = '';
    public Collection $statuses;

    protected $queryString = [
        'statusFilter' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    protected $rules = [
        'statusFilter' => 'sometimes|in:all,1,2,3,4,5,6,7,8', // Update with your actual status IDs
        'search' => 'sometimes|string|max:255',
    ];

    public function mount()
    {
        $this->statuses = Cache::remember('case_statuses', now()->addDay(), function () {
            return CaseStatus::all();
        });
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->validate();

        $query = Casee::query()
            ->where('customer_id', Auth::id())
            ->with([
                'caseStatus:id,name',
                'caseType:id,name',
                'lawyer:id,name',
                'lawyer.roles:id,name',
                'customer:id,name',
            ]);

        if ($this->statusFilter !== 'all') {
            $query->where('case_status_id', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.customer.main.casess-customer', [
            'cases' => $query->latest()->paginate(9),
        ]);
    }
}