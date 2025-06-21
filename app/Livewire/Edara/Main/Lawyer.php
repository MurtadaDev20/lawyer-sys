<?php

namespace App\Livewire\Edara\Main;

use App\Helpers\PhoneCleanerHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use Livewire\Component;
use Livewire\WithPagination;

class Lawyer extends Component
{
     use WithPagination;

    public $name, $email, $phone, $address, $password ,
        $statusFilter = 'all'; // Default filter for all statuses
    public $lawyerId;
    public $active_at, $expired_at;
    public $isModalOpen = false;
    public $search = '';

    public function rules(){
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->lawyerId)],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required_if:lawyerId,null|string|min:8|nullable',
            'active_at' => 'required|date',
            'expired_at' => 'required|date|after:active_at',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
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

        $lawyers = User::role('lawyer')
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
            ->latest()
            ->paginate(10);

        return view('livewire.edara.main.lawyer', [
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
            'active_at', 'expired_at', 'lawyerId'
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

        $user = User::updateOrCreate(['id' => $this->lawyerId], $data);

        // Assign lawyer role if not already assigned
        if (!$user->hasRole('lawyer')) {
            $user->assignRole('lawyer');
        }

        toastr()->success( 'تم إضافة المحامي بنجاح');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $lawyer = User::findOrFail($id);
        $this->lawyerId = $lawyer->id;
        $this->name = $lawyer->name;
        $this->email = $lawyer->email;
        $this->phone = $lawyer->phone;
        $this->address = $lawyer->address;
        $this->active_at = $lawyer->active_at ? Carbon::parse($lawyer->active_at)->format('Y-m-d') : '';
        $this->expired_at = $lawyer->expired_at ? Carbon::parse($lawyer->expired_at)->format('Y-m-d') : '';
        $this->openModal();
    }
    public function delete($id)
    {
        $lawyer = User::findOrFail($id);
        $lawyer->delete();

        toastr()->success('تم حذف المحامي بنجاح');
    }

    // Helper method to get status
    public function getStatus($lawyer)
    {
        $now = now();
        $expiredAt = Carbon::parse($lawyer->expired_at);
        $activeAt = Carbon::parse($lawyer->active_at);

        if ($now->gt($expiredAt)) {
            return ['text' => 'منتهي', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100'];
        } elseif ($now->lt($activeAt) || !$lawyer->is_active) {
            return ['text' => 'غير مفعل', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100'];
        } else {
            return ['text' => 'نشط', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100'];
        }
    }

    public function activate($id)
    {
        $lawyer = User::findOrFail($id);
        $lawyer->is_active = true;
        $lawyer->active_at = now();
        // $lawyer->expired_at = now()->addYear();
        $lawyer->save();

        toastr()->success('تم تفعيل المحامي بنجاح');
    }
    public function deactivate($id)
    {
        $lawyer = User::findOrFail($id);
        $lawyer->is_active = false;
        $lawyer->save();

        toastr()->success('تم إلغاء تفعيل المحامي بنجاح');
    }

}
