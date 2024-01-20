<?php

namespace Tests\Feature\Services;

use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\EmployeeWorkExperience;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    use WithFaker;

    private EmployeeService $employeeService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();
        $this->employeeService = $this->app->make(EmployeeService::class);
    }

    private function generateEmployeeEducations(int $amount = 1) : array
    {
        $employeeEducations = [];
        for ($i=0; $i < $amount; $i++) { 
            $employeeEducations[] = [
                'school_name' => $this->faker->name(),
                'major' => $this->faker->name(),
                'entry_year' => $this->faker->year(),
                'graduation_year' => $this->faker->year(),
            ];
        }

        return $employeeEducations;
    }

    private function generateEmployeeWorkExperiences(int $amount = 1) : array
    {
        $employeeWorkExperiences = [];
        for ($i=0; $i < $amount; $i++) { 
            $employeeWorkExperiences[] = [
                'company_name' => $this->faker->name(),
                'position' => $this->faker->name(),
                'year' => $this->faker->year(),
                'description' => $this->faker->text(),
            ];
        }

        return $employeeWorkExperiences;
    }

    public function testCreateEmployee(): Employee
    {
        $educationTestAmount = 3;
        $workExperienceTestAmount = 3;

        $fakePhoto = UploadedFile::fake()->image(uniqid() . '.jpeg');

        $employeeEducations = $this->generateEmployeeEducations($educationTestAmount);
        $employeeWorkExperiences = $this->generateEmployeeWorkExperiences($workExperienceTestAmount);

        $employee = $this->employeeService->create(
            $this->faker->name(),
            $this->faker->numberBetween(10000000, 99999999),
            $fakePhoto,
            $this->faker->address(),
            $employeeEducations,
            $employeeWorkExperiences,
        );

        self::assertNotNull($employee);
        self::assertCount($educationTestAmount, $employee->educations);
        self::assertCount($workExperienceTestAmount, $employee->workExperiences);

        return $employee->refresh();
    }

    public function testUpdateEmployeeWithoutNewTransaction(): void
    {
        $employee = $this->testCreateEmployee();

        $educationTestAmount = count($employee->educations);
        $workExperienceTestAmount = count($employee->workExperiences);

        $fakePhoto = UploadedFile::fake()->image(uniqid() . '.jpeg');

        $employeeEducations = [];
        foreach ($employee->educations as $education) {
            $employeeEducations[] = [
                'id' => $education->id,
                'school_name' => $this->faker->name(),
                'major' => $this->faker->name(),
                'entry_year' => $this->faker->year(),
                'graduation_year' => $this->faker->year(),
            ];
        }
        $employeeWorkExperiences = [];
        foreach ($employee->workExperiences as $workExperience) {
            $employeeWorkExperiences[] = [
                'id' => $workExperience->id,
                'company_name' => $this->faker->name(),
                'position' => $this->faker->name(),
                'year' => $this->faker->year(),
                'description' => $this->faker->text(),
            ];
        }

        $updatedEmployee = $this->employeeService->update(
            $employee,
            $this->faker->name(),
            $this->faker->numberBetween(10000000, 99999999),
            $fakePhoto,
            $this->faker->address(),
            $employeeEducations,
            $employeeWorkExperiences,
        );

        self::assertNotNull($updatedEmployee);
        self::assertEquals($employee->id, $updatedEmployee->id);
        self::assertCount($educationTestAmount, $updatedEmployee->educations);
        self::assertCount($workExperienceTestAmount, $updatedEmployee->workExperiences);

        $updatedEmployee->educations
            ->each(function (EmployeeEducation $education, int $idx) use ($employeeEducations) {
            self::assertEquals($employeeEducations[$idx]['school_name'], $education->school_name);
        });

        $updatedEmployee->workExperiences
            ->each(function (EmployeeWorkExperience $workExperience, int $idx) use ($employeeWorkExperiences) {
            self::assertEquals($employeeWorkExperiences[$idx]['company_name'], $workExperience->company_name);
        });
    }

    public function testUpdateEmployeeWithNewTransaction(): void
    {
        $employee = $this->testCreateEmployee();

        $educationTestAmount = 3;
        $workExperienceTestAmount = 3;

        $fakePhoto = UploadedFile::fake()->image(uniqid() . '.jpeg');

        $employeeEducations = $this->generateEmployeeEducations($educationTestAmount);
        $employeeWorkExperiences = $this->generateEmployeeWorkExperiences($workExperienceTestAmount);

        $updatedEmployee = $this->employeeService->update(
            $employee,
            $this->faker->name(),
            $this->faker->numberBetween(10000000, 99999999),
            $fakePhoto,
            $this->faker->address(),
            $employeeEducations,
            $employeeWorkExperiences,
        );

        self::assertNotNull($updatedEmployee);
        self::assertEquals($employee->id, $updatedEmployee->id);
        self::assertCount($educationTestAmount, $updatedEmployee->educations);
        self::assertCount($workExperienceTestAmount, $updatedEmployee->workExperiences);

        $updatedEmployee->educations
            ->each(function (EmployeeEducation $education, int $idx) use ($employeeEducations) {
            self::assertEquals($employeeEducations[$idx]['school_name'], $education->school_name);
        });

        $updatedEmployee->workExperiences
            ->each(function (EmployeeWorkExperience $workExperience, int $idx) use ($employeeWorkExperiences) {
            self::assertEquals($employeeWorkExperiences[$idx]['company_name'], $workExperience->company_name);
        });
    }

    public function testDeleteEmployee() : void
    {
        $employee = $this->testCreateEmployee();

        $this->employeeService->delete($employee);
    }

    public function testGetPaginate() : void
    {
        $this->testCreateEmployee();
        $this->testCreateEmployee();
        $this->testCreateEmployee();

        $employees = $this->employeeService->getPaginate(2);

        self::assertCount(2, $employees->items());
    }
}
