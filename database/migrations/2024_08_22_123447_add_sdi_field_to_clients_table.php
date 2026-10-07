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
		    $table->string('sdi', 7)->after('vat')->nullable();
	    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
	    Schema::table(config('clients.models.client.table'), function (Blueprint $table) {
		    $table->dropColumn('sdi');
	    });
    }
};
