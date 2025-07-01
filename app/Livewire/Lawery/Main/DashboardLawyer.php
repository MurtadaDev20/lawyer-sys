<?php

namespace App\Livewire\Lawery\Main;

use Livewire\Attributes\Layout;
use Livewire\Component;

class DashboardLawyer extends Component
{
     #[Layout('components.layouts.lawyer.app')] 
    protected $lazy = true;
    public function render()
    {
        return view('livewire.lawery.main.dashboard-lawyer');
    }
}
