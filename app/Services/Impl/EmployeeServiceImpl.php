<?php

namespace App\Services\Impl;

use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\EmployeeWorkExperience;
use App\Services\EmployeeService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EmployeeServiceImpl implements EmployeeService
{
    public function getPaginate(int $perPage = 10): Paginator
    {
        return Employee::paginate($perPage);
    }

    public function create(
        string $name,
        string $idCardNumber,
        UploadedFile $photo,
        ?string $address = null,
        array $employeeEducations = [],
        array $employeeWorkExperiences = []
    ): Employee
    {
        $photoName = $photo->storePublicly(Employee::PHOTO_PATH, 'public');

        $employee = Employee::create([
            'name' => $name,
            'address' => $address,
            'id_card_number' => $idCardNumber,
            'photo' => $photoName,
        ]);

        $employee->educations()->createMany($employeeEducations); // I use multiple inserts for better performance
        $employee->workExperiences()->createMany($employeeWorkExperiences); // I use multiple inserts for better performance

        return $employee;
    }

    public function update(
        Employee|int $employee,
        string $name,
        string $idCardNumber,
        ?UploadedFile $photo = null,
        ?string $address = null,
        array $employeeEducations = [],
        array $employeeWorkExperiences = []
    ): Employee
    {
        $employee = $this->getEmployeeModel($employee);

        $photoName = $employee->photo;
        if (!empty($photo)) {
            $publicStorage = Storage::disk('public');

            // delete old picture
            if ($publicStorage->exists($photoName)) {
                $publicStorage->delete($photoName);
            }

            $photoName = $photo->storePublicly(Employee::PHOTO_PATH, 'public');
        }

        $employee->update([
            'name' => $name,
            'address' => $address,
            'id_card_number' => $idCardNumber,
            'photo' => $photoName,
        ]);

        $this->updateEducations($employee, $employeeEducations);
        $this->updateWorkExperiences($employee, $employeeWorkExperiences);

        return $employee->refresh();
    }

    public function delete(Employee|int $employee): void
    {
        $employee = $this->getEmployeeModel($employee);

        // delete picture
        $publicStorage = Storage::disk('public');
        if ($publicStorage->exists($employee->photo)) {
            $publicStorage->delete($employee->photo);
        }

        $employee->delete();
    }

    private function getEmployeeModel(Employee|int $employee): ?Employee
    {
        if (is_int($employee)) {
            return Employee::find($employee);
        }
        return $employee;
    }

    private function updateEducations(Employee $employee, array $employeeEducations): Employee
    {
        $existingIds = $employee->educations->pluck('id')->toArray();
        $keepDataIds = [];
        $createEducations = [];
        foreach ($employeeEducations as $education) {
            // update
            if (isset($education['id']) && in_array($education['id'], $existingIds)) {
                $keepDataIds[] = $education['id'];
                EmployeeEducation::where('id', $education['id'])->update($education);
            } else {
                $createEducations[] = $education;
            }
        }
        EmployeeEducation::whereNotIn('id', $keepDataIds)->delete(); // I use multiple deletes for better performance
        $employee->educations()->createMany($createEducations); // I use multiple inserts for better performance

        return $employee;
    }

    private function updateWorkExperiences(Employee $employee, array $employeeWorkExperiences): Employee
    {
        $existingIds = $employee->workExperiences->pluck('id')->toArray();
        $keepDataIds = [];
        $createWorkExperience = [];
        foreach ($employeeWorkExperiences as $workExperience) {
            // update
            if (isset($workExperience['id']) && in_array($workExperience['id'], $existingIds)) {
                $keepDataIds[] = $workExperience['id'];
                EmployeeWorkExperience::where('id', $workExperience['id'])->update($workExperience);
            } else {
                $createWorkExperience[] = $workExperience;
            }
        }
        EmployeeWorkExperience::whereNotIn('id', $keepDataIds)->delete(); // I use multiple deletes for better performance
        $employee->workExperiences()->createMany($createWorkExperience); // I use multiple inserts for better performance

        return $employee;
    }
}