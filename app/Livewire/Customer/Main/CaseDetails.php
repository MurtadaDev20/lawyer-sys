<?php

namespace App\Livewire\Customer\Main;

use App\Models\Casee;
use App\Models\File;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class CaseDetails extends Component
{
    #[Layout('components.layouts.customer.app')] 
    #[Title('تفاصيل القضية')]

    public $caseId ,
           $statuses = [],
           $status = 'all',
           $name,
           $customer_case_id,
           $statusCase = 'all';

    public function mount($id)
        {
            $this->caseId = $id;
            $this->statuses = \App\Models\CaseStatus::all();
            $this->customer_case_id = Casee::where('id', $id)
                ->where('customer_id', Auth::id())->first();
        }




    public function render()
    {
        $files = File::where('case_id', $this->caseId)
            ->where('customer_id', Auth::id())
            ->paginate(10);

        $case = Casee::with(['lawyer', 'customer', 'caseType', 'caseStatus'])
            ->where('id', $this->caseId)
            ->where('customer_id', Auth::id())
            ->firstOrFail();
        return view('livewire.customer.main.case-details', [
            'case' => $case,
            'files' => $files,
        ]
    
    );
    }
}
