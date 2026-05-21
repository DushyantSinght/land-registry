<?php
// app/Models/Property.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'survey_number', 'plot_number', 'khasra_number', 'land_type', 'land_use',
        'village', 'taluka', 'district', 'state', 'pincode', 'address_description',
        'latitude', 'longitude',
        'area_sqft', 'area_acres', 'length_ft', 'width_ft',
        'market_value', 'government_value', 'valuation_year',
        'current_owner_id', 'status', 'has_disputes', 'dispute_notes',
        'site_plan', 'survey_document', 'created_by',
    ];

    protected $casts = [
        'area_sqft'        => 'decimal:2',
        'area_sqm'         => 'decimal:2',
        'market_value'     => 'decimal:2',
        'government_value' => 'decimal:2',
        'has_disputes'     => 'boolean',
        'latitude'         => 'decimal:8',
        'longitude'        => 'decimal:8',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function currentOwner()
    {
        return $this->belongsTo(Owner::class, 'current_owner_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function history()
    {
        return $this->hasMany(PropertyHistory::class)->orderByDesc('from_date');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('survey_number', 'like', "%{$term}%")
              ->orWhere('plot_number',  'like', "%{$term}%")
              ->orWhere('district',     'like', "%{$term}%")
              ->orWhere('taluka',       'like', "%{$term}%");
        });
    }

    public function scopeByDistrict($query, $district)
    {
        return $query->when($district, fn ($q) => $q->where('district', $district));
    }

    public function scopeByLandType($query, $type)
    {
        return $query->when($type, fn ($q) => $q->where('land_type', $type));
    }

    public function scopeByStatus($query, $status)
    {
        return $query->when($status, fn ($q) => $q->where('status', $status));
    }

    // ─── Boot ─────────────────────────────────────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        // Auto-generate survey number if not supplied
        static::creating(function ($model) {
            if (empty($model->survey_number)) {
                $year  = now()->year;
                $count = static::whereYear('created_at', $year)->count() + 1;
                $model->survey_number = 'SRV-' . $year . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'available'          => 'success',
            'registered'         => 'primary',
            'disputed'           => 'danger',
            'mortgaged'          => 'warning',
            'government_acquired'=> 'secondary',
            default              => 'light',
        };
    }

    public function getLandTypeLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->land_type));
    }

    public function getFullLocationAttribute(): string
    {
        return implode(', ', array_filter([
            $this->village, $this->taluka, $this->district, $this->state,
        ]));
    }

    public function getSitePlanUrlAttribute(): ?string
    {
        return $this->site_plan ? asset('storage/' . $this->site_plan) : null;
    }
}
