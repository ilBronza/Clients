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
        Schema::create(config('clients.models.clienthash.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on(
                config('clients.models.client.table')
            );

            $table->timestamp('used_at')->nullable();

            $table->boolean('permanent')->nullable();
            $table->timestamp('valid_to')->nullable();

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
        Schema::dropIfExists(config('clients.models.clienthash.table'));
    }
};
