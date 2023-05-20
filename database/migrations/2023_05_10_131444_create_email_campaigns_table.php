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
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('emails');
            $table->integer('status')->default(0)->comment('0 = inactive , 1 = launched , 2 = canceled , 3 = finished');
            $table->integer('progress')->default(0);
            $table->integer('time_gap');
            $table->unsignedBigInteger('template_id')->nullable();
            $table->timestamp('launch_at');
            $table->timestamps();
            $table->foreign('template_id')->references('id')->on('email_templates')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_campaigns');
    }
};
