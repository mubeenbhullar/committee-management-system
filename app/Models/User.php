<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cnic',
        'address',
        'password',
        'avatar',
        'status',
        'bank_account_number',
        'bank_name',
        'easypaisa_number',
        'jazzcash_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // Relationships
    public function committees()
    {
        return $this->hasMany(\App\Models\Committee::class, 'admin_id');
    }
    
    public function memberCommittees()
    {
        return $this->belongsToMany(\App\Models\Committee::class, 'committee_members')
                    ->withPivot('member_number', 'is_admin', 'status')
                    ->withTimestamps();
    }
    
    public function installments()
    {
        return $this->hasMany(\App\Models\Installment::class);
    }
}