<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Schema::disableForeignKeyConstraints();
        Member::truncate();
        Schema::enableForeignKeyConstraints();
        return [
            'name'=>$this->faker->firstName(),
            'phone'=>$this->faker->unique()->numberBetween(111111,9999999999),
        ];
    }
}
