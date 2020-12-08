<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'employee_id',
        'city_id',
        'county_id',
        'address',
        'date',
        'started_at',
        'finished_at',
        'status'
    ];

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
