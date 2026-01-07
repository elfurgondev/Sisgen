<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'property_id',
        'status',
        'financial_data',
        'amortization_schedule',
    ];

    protected $casts = [
        'financial_data' => 'array',
        'amortization_schedule' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
