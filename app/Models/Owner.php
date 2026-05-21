<?php
// app/Models/Owner.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_number', 'full_name', 'owner_type', 'id_type', 'id_number',
        'date_of_birth', 'nationality', 'phone', 'email', 'address',
        'city', 'state', 'pincode', 'photo', 'id_document',
        'is_active', 'created_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active'     => 'boolean',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function properties()
    {
        return $this->hasMany(Property::class, 'current_owner_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'from_owner_id')
            ->orWhere('to_owner_id', $this->id);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('full_name', 'like', "%{$term}%")
              ->orWhere('id_number', 'like', "%{$term}%")
              ->orWhere('owner_number', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    // ─── Boot ─────────────────────────────────────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->owner_number)) {
                $year = now()->year;
                $count = static::whereYear('created_at', $year)->count() + 1;
                $model->owner_number = 'OWN-' . $year . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getOwnerTypeLabelAttribute(): string
    {
        return match ($this->owner_type) {
            'individual' => 'Individual',
            'company'    => 'Company / Firm',
            'government' => 'Government Body',
            default      => ucfirst($this->owner_type),
        };
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/avatar-placeholder.png');
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }
}
