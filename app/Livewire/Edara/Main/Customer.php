<?php

namespace App\Livewire\Edara\Main;

use App\Helpers\PhoneCleanerHelper;
use App\Models\CustomerLawyer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Customer extends Component
{ use WithPagination;
    #[Title('إدارة العملاء')] 
    public $name, $email, $phone, $address, $password , $lower_id,
        $statusFilter = 'all' , $lawyerFilter ;
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
            'active_at' => 'required|date',
            'expired_at' => 'required|date|after:active_at',
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
            'active_at.required' => 'تاريخ التفعيل مطلوب',
            'active_at.date' => 'تاريخ التفعيل يجب أن يكون تاريخاً صالحاً',
            'expired_at.required' => 'تاريخ الانتهاء مطلوب',
            'expired_at.date' => 'تاريخ الانتهاء يجب أن يكون تاريخاً صالحاً',
            'expired_at.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ التفعيل',
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
                    $query->where('active_at', '<=', $now)
                        ->where('expired_at', '>=', $now)
                        ->where('is_active', '=', true);
                } elseif ($this->statusFilter === 'expired') {
                    $query->where('expired_at', '<', $now);
                } elseif ($this->statusFilter === 'not_active') {
                    $query->where('is_active', '=', false);
                }
            })
            ->when($this->lawyerFilter, function ($query) {
                $query->where('lawyer_id', $this->lawyerFilter);
            })
            ->with('lawyers')
            ->latest()
            ->paginate(10);

        return view('livewire.edara.main.customer', [
            'customers' => $customers,
            'lawyers' => $lawyers,
            'cities' => ['بغداد', 'البصرة', 'النجف', 'أربيل', 'كركوك', 'الموصل'],
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
            'phone' => $phoneNumber,
            'address' => $this->address,
            'active_at' => $this->active_at,
            'expired_at' => $this->expired_at,
        ];

        
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->customerId], $data);

        if($user){
            $datacustlawer = [
            'lawyer_id' => $this->lower_id,
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
        $this->active_at = $customers->active_at ? Carbon::parse($customers->active_at)->format('Y-m-d') : '';
        $this->expired_at = $customers->expired_at ? Carbon::parse($customers->expired_at)->format('Y-m-d') : '';
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

        if ($now->gt($expiredAt)) {
            return ['text' => 'منتهي', 'class' => 'bg-red-500 text-red-800 dark:bg-red-900 dark:text-red-100'];
        } elseif ($now->lt($activeAt) || !$customer->is_active) {
            return ['text' => 'غير مفعل', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100'];
        } else {
            return ['text' => 'نشط', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100'];
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
