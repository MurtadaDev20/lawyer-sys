<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Casee extends Model
{
    protected $fillable = [
        'case_type_id',
        'case_status_id',
        'title',
        'description',
        'created_at',
        'updated_at',
        'case_number',
        'lawyer_id',
        'customer_id',
        'start_date',
        'due_date',
        'closed_date',
        'court_name',
        'location',
    ];

    public function caseType()
    {
        return $this->belongsTo(CaseType::class);
    }

    public function caseStatus()
    {
        return $this->belongsTo(CaseStatus::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
