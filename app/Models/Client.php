<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'personal_data',
        'status',
    ];

    protected $casts = [
        'personal_data' => 'array',
    ];

    public function salesProcesses()
    {
        return $this->hasMany(SalesProcess::class);
    }
}
