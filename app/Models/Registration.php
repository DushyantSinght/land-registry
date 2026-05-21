<?php
// app/Models/Registration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_number', 'property_id', 'owner_id', 'registration_type',
        'registration_date', 'execution_date', 'sub_registrar_office',
        'document_number', 'transaction_value', 'stamp_duty', 'registration_fee',
        'status', 'remarks', 'rejection_reason',
        'witness1_name', 'witness1_id', 'witness2_name', 'witness2_id',
        'deed_document', 'supporting_doc1', 'supporting_doc2',
        'created_by', 'approved_by', 'approved_at',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'execution_date'    => 'date',
        'approved_at'       => 'datetime',
        'transaction_value' => 'decimal:2',
        'stamp_duty'        => 'decimal:2',
        'registration_fee'  => 'decimal:2',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function transfer()
    {
        return $this->hasOne(Transfer::class);
    }

    // ─── Boot ─────────────────────────────────────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->registration_number)) {
                $year  = now()->year;
                $count = static::whereYear('created_at', $year)->count() + 1;
                $model->registration_number = 'REG-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('registration_number', 'like', "%{$term}%")
              ->orWhereHas('property', fn ($pq) => $pq->where('survey_number', 'like', "%{$term}%"))
              ->orWhereHas('owner', fn ($oq) => $oq->where('full_name', 'like', "%{$term}%"));
        });
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'approved'  => 'success',
            'rejected'  => 'danger',
            'cancelled' => 'secondary',
            default     => 'light',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->registration_type));
    }

    public function getTotalFeeAttribute(): float
    {
        return (float) $this->stamp_duty + (float) $this->registration_fee;
    }
}
