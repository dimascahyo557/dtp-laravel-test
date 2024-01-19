<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;

interface EmployeeService
{
    public function getPaginate(int $perPage = 10): Paginator;

    public function create(
        string $name,
        string $idCardNumber,
        UploadedFile $photo,
        ?string $address = null,
        array $employeeEducations = [],
        array $employeeWorkExperiences = []
    ): Employee;

    public function update(
        Employee|int $employee,
        string $name,
        string $idCardNumber,
        ?UploadedFile $photo = null,
        ?string $address = null,
        array $employeeEducations = [],
        array $employeeWorkExperiences = []
    ): Employee;

    public function delete(Employee|int $employee): void;
}