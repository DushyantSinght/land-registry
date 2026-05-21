<?php
// app/Models/PropertyHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyHistory extends Model
{
    protected $fillable = ['property_id', 'owner_id', 'from_date', 'to_date', 'event_type', 'notes'];

    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
