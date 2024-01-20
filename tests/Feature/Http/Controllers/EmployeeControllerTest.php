<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use WithFaker;

    private EmployeeService $employeeService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();
        $this->employeeService = $this->app->make(EmployeeService::class);
    }

    private function firstOrCreateEmployee(): Employee
    {
        $employees = $this->employeeService->getPaginate(1);
        if (empty($employees)) {
            $employees = Employee::factory(1)->create();
        }
        return $employees->first();
    }

    public function testIndex(): void
    {
        $employee = $this->firstOrCreateEmployee();

        $this->get(action([EmployeeController::class, 'index']))
            ->assertStatus(200)
            ->assertSeeText($employee->name);
    }

    public function testCreate() : void
    {
        $this->get(action([EmployeeController::class, 'create']))
            ->assertStatus(200);
    }

    public function testStoreSuccess(): void
    {
        $request = [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'id_card_number' => $this->faker->numberBetween(10000000, 99999999),
            'photo' => UploadedFile::fake()->image(uniqid() . '.jpeg'),
            'educations' => [
                [
                    'school_name' => $this->faker->name(),
                    'major' => $this->faker->name(),
                    'entry_year' => $this->faker->year(),
                    'graduation_year' => $this->faker->year(),
                ],
            ],
            'work_experiences' => [
                [
                    'company_name' => $this->faker->name(),
                    'position' => $this->faker->name(),
                    'year' => $this->faker->year(),
                    'description' => $this->faker->text(),
                ]
            ],
        ];

        $this->post(action([EmployeeController::class, 'store']), $request)
            ->assertRedirect(action([EmployeeController::class, 'index']))
            ->assertSessionHas('success', __('message.store-success'));
    }

    public function testShow(): void
    {
        $employee = $this->firstOrCreateEmployee();

        $this->get(action([EmployeeController::class, 'show'], ['employee' => $employee->id]))
            ->assertStatus(200);
    }

    public function testEdit(): void
    {
        $employee = $this->firstOrCreateEmployee();

        $this->get(action([EmployeeController::class, 'edit'], ['employee' => $employee->id]))
            ->assertStatus(200);
    }

    public function testUpdateSuccess(): void
    {
        $employee = $this->firstOrCreateEmployee();
        $request = [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'id_card_number' => $this->faker->numberBetween(10000000, 99999999),
            'photo' => UploadedFile::fake()->image(uniqid() . '.jpeg'),
            'educations' => [
                [
                    'school_name' => $this->faker->name(),
                    'major' => $this->faker->name(),
                    'entry_year' => $this->faker->year(),
                    'graduation_year' => $this->faker->year(),
                ],
            ],
            'work_experiences' => [
                [
                    'company_name' => $this->faker->name(),
                    'position' => $this->faker->name(),
                    'year' => $this->faker->year(),
                    'description' => $this->faker->text(),
                ]
            ],
        ];

        $this->put(action([EmployeeController::class, 'update'], ['employee' => $employee->id]), $request)
            ->assertRedirect(action([EmployeeController::class, 'index']))
            ->assertSessionHas('success', __('message.update-success'));
    }

    public function testDestroySuccess(): void
    {
        $employee = $this->firstOrCreateEmployee();

        $this->delete(action([EmployeeController::class, 'destroy'], ['employee' => $employee->id]))
            ->assertRedirect(action([EmployeeController::class, 'index']))
            ->assertSessionHas('success', __('message.destroy-success'));
    }
}
