<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    const PHOTO_PATH = '/employee/img';

    protected $fillable = [
        'name',
        'address',
        'id_card_number',
        'photo',
    ];

    /**
     * Get all of the educations for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educations(): HasMany
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    /**
     * Get all of the workExperience for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workExperiences(): HasMany
    {
        return $this->hasMany(EmployeeWorkExperience::class);
    }
}
