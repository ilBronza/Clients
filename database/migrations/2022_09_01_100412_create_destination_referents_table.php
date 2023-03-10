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
        Schema::create('destination_referents', function (Blueprint $table) {
            $table->id('id');

            $table->uuid('destination_id');
            $table->uuid('referent_id');

            $table->unsignedSmallInteger('priority')->default(0);

            $table->foreign('destination_id')->references('id')->on('destinations');
            $table->foreign('referent_id')->references('id')->on('referents');

            $table->unique(['destination_id', 'referent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destination_referents');
    }
};
