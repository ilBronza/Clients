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
            $table->string('first_color', 8)->nullable();
            $table->string('second_color', 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('clients.models.client.table'), function (Blueprint $table) {
            $table->dropColumn(['first_color', 'second_color']);
        });
    }
};
