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
        Schema::create(config('clients.models.referenttypeReferent.table'), function (Blueprint $table) {
            $table->id('id');

            $table->uuid('referent_id');
            $table->string('type_slug');

            $table->foreign('referent_id')->references('id')->on(
                config('clients.models.referent.table')
            );
            $table->foreign('type_slug')->references('slug')->on(
                config('clients.models.referenttype.table')
            );

            $table->unique(['referent_id', 'type_slug'], 'dest_type_unique');

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
        Schema::dropIfExists(config('clients.models.referenttypeReferent.table'));
    }
};
