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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('pdf');
            $table->string('photo');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('research_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate('cascade');
            $table->foreign('research_id')->references('id')->on('users_researches')->onDelete("cascade")->onUpdate('cascade');
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
        Schema::dropIfExists('documents');
    }
};
