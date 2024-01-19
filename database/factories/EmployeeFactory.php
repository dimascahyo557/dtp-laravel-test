<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeImage = fake()->image(storage_path("app/public" . Employee::PHOTO_PATH), fullPath: false);
        return [
            'name' => fake()->name(),
            'address' => fake()->address(),
            'id_card_number' => fake()->numberBetween(10000000, 99999999),
            'photo' => Employee::PHOTO_PATH . '/' . $fakeImage,
        ];
    }
}
