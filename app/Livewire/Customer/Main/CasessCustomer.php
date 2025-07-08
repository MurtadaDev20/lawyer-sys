<?php

namespace App\Livewire\Customer\Main;

use App\Models\Casee;
use Livewire\Component;
use App\Models\CaseStatus;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class CasessCustomer extends Component
{
    #[Layout('components.layouts.customer.app')]
    public $statusFilter = 'all';
    public $search = '';
    public $statuses = [];

    public function mount()
    {
        $this->statuses = CaseStatus::all();

    }
    public function render()
    {
        $query = Casee::query()
        ->where('customer_id', Auth::id())
        ->with(['caseStatus', 'caseType']);

        if ($this->statusFilter !== 'all') {
            $query->where('case_status_id', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        return view('livewire.customer.main.casess-customer',[
            'cases' => $query->latest()->paginate(9),
        ]
        
    );
    }

  
}
