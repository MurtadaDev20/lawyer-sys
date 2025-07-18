<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lawyer_id',
        'phone',
        'address',
        'is_active',
        'active_at',
        'expired_at',
        'is_verified',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

     public function lawyers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'customer_lawyers', 'customer_id', 'lawyer_id');
    }

    /**
     * Get the customers assigned to this lawyer.
     */
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'customer_lawyers', 'lawyer_id', 'customer_id');
    }

    /**
     * Get the cases associated with this user.
     */
    public function cases()
    {
        return $this->hasMany(Casee::class, 'lawyer_id', 'id'); 
    }
    /**
     * Get the cases assigned to this user.
     */
    public function assignedCases()
    {
        return $this->hasMany(Casee::class, 'customer_id', 'id');
    }   

}