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
        Schema::create('messages', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement();
            $table->string('msg_id',255)->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');
            $table->longText('body')->nullable();
            $table->string('media_url',255)->nullable();
            $table->string('msg_type',255)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('from_me')->comment('1->yes, 0->no');
            $table->integer('user_id')->default(0);
            $table->dateTime('msg_date')->nullable();
            $table->string('contact_number',255)->nullable();
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
        Schema::dropIfExists('messages');
    }
};
