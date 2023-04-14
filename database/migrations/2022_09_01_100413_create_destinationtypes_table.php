<?php

use IlBronza\Clients\Models\Destinationtype;
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
        Schema::create(config('clients.models.destinationtype.table'), function (Blueprint $table)
        {
            $table->string('name');
            $table->string('slug')->primary();

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
        Schema::dropIfExists(config('clients.models.destinationtype.table'));
    }
};
