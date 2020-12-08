<?php

namespace App\Models;

use App\Enums\JobStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'api_token',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function notCompletedJobs(): HasMany
    {
        return $this->hasMany(Job::class, 'employee_id', 'id')
            ->where('status', '<>', JobStatusEnum::STATUSES[JobStatusEnum::COMPLETED]);
    }
}
