<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Branch;
use App\Models\Organization;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Schema::disableForeignKeyConstraints();
        Department::truncate();
        Schema::enableForeignKeyConstraints();
        $branch = Branch::InRandomOrder()->first();
        return [
            'name' => $this->faker->firstName(),
            'desc' => $this->faker->text(10),
            'phone' => $this->faker->unique()->numberBetween(111111,9999999999),
            'status' => mt_rand(0,1),
            'branch_id' => $branch->id,
            'organization_id' => $branch->organization_id,
        ];
    }
}
