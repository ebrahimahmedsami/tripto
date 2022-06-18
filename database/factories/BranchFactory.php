<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Branch;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Schema::disableForeignKeyConstraints();
        Branch::truncate();
        Schema::enableForeignKeyConstraints();
        return [
            'name' => $this->faker->firstName(),
            'phone' => $this->faker->unique()->numberBetween(1111111,9999999999),
            'address' => $this->faker->address,
            'organization_id' => Organization::inRandomOrder()->first()->id
        ];
    }
}
