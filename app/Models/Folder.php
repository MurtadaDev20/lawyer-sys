<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    
    protected $fillable = [
        'name',
        'description',
        'lawyer_id',
        'created_by',
        'updated_by',
    ];

    public function lawyer()
    {
        return $this->belongsTo(User::class);
    }
}
