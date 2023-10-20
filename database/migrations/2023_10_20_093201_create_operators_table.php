<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('clients.models.operator.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('first_name')->nullable();
            $table->string('family_name')->nullable();

            $table->uuid('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on(config('clients.models.client.table'));

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create(config('clients.models.clientOperator.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('operator_id')->nullable();
            $table->foreign('operator_id')->references('id')->on(config('clients.models.operator.table'));

            $table->uuid('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on(config('clients.models.client.table'));

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('clients.models.clientOperator.table'));
        Schema::dropIfExists(config('clients.models.operator.table'));
    }
};
