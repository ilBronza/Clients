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
        Schema::create(config('clients.models.destination.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on(
                config('clients.models.client.table')
            );

            $table->string('name');
            $table->string('slug');

            $table->string('type')->nullable();

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
        Schema::dropIfExists(config('clients.models.destination.table'));
    }
};
