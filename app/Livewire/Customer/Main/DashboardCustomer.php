<?php

namespace App\Livewire\Customer\Main;

use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardCustomer extends Component
{
    #[Layout('components.layouts.customer.app')] 
    public function render()
    {
        return view('livewire.customer.main.dashboard-customer');
    }
}
