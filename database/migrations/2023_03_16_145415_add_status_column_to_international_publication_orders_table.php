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
        Schema::table('international_publication_orders', function (Blueprint $table) {
           $table->string('status')->nullable();
           $table->string('title')->nullable();
           $table->string('reason_to_refused')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('international_publication_orders', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('reason_to_refused');
        });
    }
};
