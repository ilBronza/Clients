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
        Schema::create(config('clients.models.destinatable.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->uuid('destination_id');

			$table->uuidMorphs('destinatable');
			$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('clients.models.destinatable.table'));
    }
};
