<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseType extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the cases associated with the case type.
     */
    public function cases()
    {
        return $this->hasMany(Casee::class);
    }
}
