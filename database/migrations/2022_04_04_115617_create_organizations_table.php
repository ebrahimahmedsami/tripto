<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1)->comment('0 InActive ,1 Active');
            $table->text('desc')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('token', 255);
            $table->string('instance_id', 255);
            $table->text('welcome_msg');
            $table->text('error_msg');
            $table->text('department_msg');
            $table->text('service_msg');
            $table->text('success_msg');
            $table->string('phone');
            $table->string('logo')->nullable();
            $table->text('qr_code');
            $table->text('website_url')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
};
