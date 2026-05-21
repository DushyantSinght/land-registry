<?php
// app/Models/Transfer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_number', 'property_id', 'from_owner_id', 'to_owner_id',
        'registration_id', 'transfer_date', 'transfer_value', 'transfer_mode',
        'reason', 'status', 'remarks', 'transfer_deed', 'created_by', 'approved_by', 'approved_at',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'approved_at'   => 'datetime',
        'transfer_value'=> 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function fromOwner()
    {
        return $this->belongsTo(Owner::class, 'from_owner_id');
    }

    public function toOwner()
    {
        return $this->belongsTo(Owner::class, 'to_owner_id');
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->transfer_number)) {
                $year  = now()->year;
                $count = static::whereYear('created_at', $year)->count() + 1;
                $model->transfer_number = 'TRF-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
            }
        });

        static::updated(function ($model) {
            if ($model->status === 'approved' && $model->isDirty('status')) {
                // Update property owner
                $model->property->update(['current_owner_id' => $model->to_owner_id]);
                // Log history
                PropertyHistory::create([
                    'property_id' => $model->property_id,
                    'owner_id'    => $model->to_owner_id,
                    'from_date'   => $model->transfer_date,
                    'event_type'  => 'transfer',
                    'notes'       => "Transferred via {$model->transfer_number}",
                ]);
            }
        });
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'light',
        };
    }
}
