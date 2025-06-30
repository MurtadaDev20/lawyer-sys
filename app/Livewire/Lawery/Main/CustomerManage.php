<?php

namespace App\Livewire\Lawery\Main;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerLawyer;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use App\Helpers\PhoneCleanerHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerManage extends Component
{
    #[Layout('components.layouts.lawyer.app')] 
    #[Title('إدارة العملاء')]

    public $name, $email, $phone, $address, $password ,
        $statusFilter = 'all'  ;
    public $customerId;
    public $active_at, $expired_at;
    public $isModalOpen = false;
    public $search = '';

    public function rules(){
        return [
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($this->customerId)],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required_if:customerId,null|string|min:8|nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل',
            'phone.required' => 'رقم الهاتف مطلوب',
            'address.required' => 'العنوان مطلوب',
            'password.required_if' => 'كلمة المرور مطلوبة عند إضافة محامي جديد',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 8 أحرف',
        ];
    }

    public function render()
    {
        $now = now();
        $lawyers = User::role('lawyer')->where('is_active' ,true)->get();
        $customers = User::role('Customer')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%')
                      ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->statusFilter && $this->statusFilter !== 'all', function ($query) use ($now) {
                if ($this->statusFilter === 'active') {
                    $query->where('is_active', '=', true);
                }  elseif ($this->statusFilter === 'not_active') {
                    $query->where('is_active', '=', false);
                }
            })
            ->with('lawyers')
            ->latest()
            ->paginate(10);

        return view('livewire.lawery.main.customer-manage', [
            'customers' => $customers,
            'cities' => ['بغداد','البصرة','نينوى','الأنبار','كربلاء','النجف','دهوك','أربيل','السليمانية','ديالى','كركوك','صلاح الدين','بابل','واسط','ميسان','ذي قار','المثنى','القادسية',],
        ]);
    }

     public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
    }
     private function resetInputFields()
    {
        $this->reset([
            'name', 'email', 'phone', 'address', 'password', 
            'active_at', 'expired_at', 'customerId'
        ]);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();
        $phoneNumber = (new PhoneCleanerHelper($this->phone))->clean();
        if ($phoneNumber == false) {
            return toastr()->error('رقم الهاتف غير صحيح.');
        }
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => true,
            'phone' => $phoneNumber,
            'address' => $this->address,
        ];

        
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->customerId], $data);

        if($user){
            $datacustlawer = [
            'lawyer_id' => Auth::user()->id, 
        ];
        $customerLawyer = CustomerLawyer::updateOrCreate(
            ['customer_id' => $user->id],
            $datacustlawer
        );
        }
        // Assign lawyer role if not already assigned
        if (!$user->hasRole('Customer')) {
            $user->assignRole('Customer');
        }

        toastr()->success( 'تم إضافة العميل بنجاح');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $customers = User::findOrFail($id);
        $this->customerId = $customers->id;
        $this->name = $customers->name;
        $this->email = $customers->email;
        $this->phone = $customers->phone;
        $this->address = $customers->address;
        $this->openModal();
    }
    public function delete($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        toastr()->success('تم حذف العميل بنجاح');
    }

    // Helper method to get status
    public function getStatus($customer)
    {
        $now = now();
        $expiredAt = Carbon::parse($customer->expired_at);
        $activeAt = Carbon::parse($customer->active_at);

        if ( !$customer->is_active) {
            return ['text' => 'غير مفعل', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100'];
        } else {
            return ['text' => 'نشط', 'class' => 'bg-primary-600 text-white dark:bg-green-800 dark:text-green-100'];
        }
    }

    public function activate($id)
    {
        $customer = User::findOrFail($id);
        $customer->is_active = true;
        $customer->active_at = now();
        // $lawyer->expired_at = now()->addYear();
        $customer->save();

        toastr()->success('تم تفعيل العميل بنجاح');
    }
    public function deactivate($id)
    {
        $customer = User::findOrFail($id);
        $customer->is_active = false;
        $customer->save();

        toastr()->success('تم إلغاء تفعيل العميل بنجاح');
    }
}
