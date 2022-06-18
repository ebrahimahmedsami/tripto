<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Schema::disableForeignKeyConstraints();
        Service::truncate();
        Schema::enableForeignKeyConstraints();
        return [
            'name' => $this->faker->firstName(),
            'status' => mt_rand(0,1),
            'desc' => $this->faker->text(10),
            'queue_number' => $this->faker->unique()->numberBetween(1,999),
            'range_time' => mt_rand(3,30),
            'department_id' => Department::inRandomOrder()->first()->id,
        ];
    }
}
