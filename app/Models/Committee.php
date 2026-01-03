<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'committee_number',
        'description',
        'total_amount',
        'number_of_members',
        'duration_months',
        'installment_amount',
        'frequency',
        'start_date',
        'status',
        'rotation_method',
        'admin_commission',
        'admin_id'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'admin_commission' => 'decimal:2',
        'start_date' => 'date'
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function members()
    {
        return $this->hasMany(CommitteeMember::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function rotations()
    {
        return $this->hasMany(Rotation::class);
    }

    // Helper Methods
    public function totalCollected()
    {
        return $this->installments()->where('status', 'paid')->sum('amount');
    }

    public function pendingInstallments()
    {
        return $this->installments()->where('status', 'pending')->count();
    }

    public function getNextRotationDate()
    {
        $lastRotation = $this->rotations()->latest()->first();
        
        if (!$lastRotation) {
            return $this->start_date;
        }

        $lastDate = \Carbon\Carbon::parse($lastRotation->rotation_date);
        
        // Frequency ke hisaab se next date calculate karein
        switch ($this->frequency) {
            case 'daily':
                return $lastDate->addDay();
            case 'weekly':
                return $lastDate->addWeek();
            case 'monthly':
                return $lastDate->addMonth();
            case '10_days':
                return $lastDate->addDays(10);
            default:
                return $lastDate->addMonth();
        }
    }
}