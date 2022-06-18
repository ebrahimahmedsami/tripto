<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Member;
use App\Models\Service;
use App\Models\MemberService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberService>
 */
class MemberServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        Schema::disableForeignKeyConstraints();
        MemberService::truncate();
        Schema::enableForeignKeyConstraints();

        return [
            'member_id' => Member::inRandomOrder()->first()->id,
            'service_id' => Service::inRandomOrder()->first()->id,
            'status' => mt_rand(0,3),
            'member_type' => mt_rand(0,1),
            'feedback' => null,
            'completed_feedback' => mt_rand(0,1),
            'current_members_service' => null,
        ];
    }
}
