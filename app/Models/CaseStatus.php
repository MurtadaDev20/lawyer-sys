<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStatus extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the cases associated with the case status.
     */
    public function cases()
    {
        return $this->hasMany(Casee::class);
    }
}
