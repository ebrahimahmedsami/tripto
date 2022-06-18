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
        Schema::create('member_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('service_id');
            $table->tinyInteger('status')->default(0)->comment(' 0=>waiting ,1 => active,2=>completed,3=.canceled');
            $table->tinyInteger('member_type')->default(0)->comment('0 =>normal , 1=>vip');
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('service_id')->references('id')->on('services');
            $table->text('feedback')->nullable();
            $table->tinyInteger('completed_feedback')->default(0)->comment('1=> completed ,0=>other status');
            $table->integer('current_members_service')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_services');
    }
};
