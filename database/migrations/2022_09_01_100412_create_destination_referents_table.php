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
        Schema::create(config('clients.models.destinationReferent.table'), function (Blueprint $table) {
            $table->id('id');

            $table->uuid('destination_id');
            $table->uuid('referent_id');

            $table->unsignedSmallInteger('priority')->default(0);

            $table->foreign('destination_id')->references('id')->on(
                config('clients.models.destination.table')
            );
            $table->foreign('referent_id')->references('id')->on(
                config('clients.models.referent.table')
            );

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
        Schema::dropIfExists(config('clients.models.destinationReferent.table'));
    }
};
