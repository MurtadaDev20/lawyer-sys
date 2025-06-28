<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLawyer extends Model
{
    protected $fillable = [
        'customer_id',
        'lawyer_id',
    ];

    
    
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    
    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }
}
