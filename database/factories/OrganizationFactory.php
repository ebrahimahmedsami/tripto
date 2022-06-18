<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Schema::disableForeignKeyConstraints();
        Organization::truncate();
        Schema::enableForeignKeyConstraints();
        return [
            'name'=> $this->faker->firstName(),
            'desc'=> $this->faker->text(10),
            'lat'=> $this->faker->latitude,
            'long'=> $this->faker->longitude,
            'email'=> $this->faker->unique()->email,
            'address'=> $this->faker->address,
            'token'=> Str::random(20),
            'instance_id'=> $this->faker->unique()->numberBetween(111111,9999999999),
            'temp_msg'=> $this->faker->realText(50),
            'phone'=> $this->faker->unique()->numberBetween(111111,999999999),
            'logo'=> null,
            'qr_code'=> Str::random(10),
            'website_url'=>null,
        ];
    }
}
