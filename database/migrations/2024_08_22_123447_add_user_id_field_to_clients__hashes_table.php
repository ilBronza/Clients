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
        Schema::table(config('clients.models.clienthash.table'), function (Blueprint $table) {
			$table->uuid('operator_id')->nullable();
			$table->foreign('operator_id')->references('id')->on(config('operators.models.operator.table'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config('clients.models.clienthash.table'), function (Blueprint $table) {
	        $table->dropForeign(['operator_id']);
	        $table->dropColumn('operator_id');
        });
    }
};
