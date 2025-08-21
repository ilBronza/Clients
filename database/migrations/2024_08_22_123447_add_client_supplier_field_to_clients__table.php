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
        Schema::table(config('clients.models.client.table'), function (Blueprint $table) {
            $table->boolean('is_client')->nullable();
            $table->boolean('is_supplier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('clients.models.client.table'), function (Blueprint $table) {
            $table->dropColumn('is_client');
            $table->dropColumn('is_supplier');
        });
    }
};
