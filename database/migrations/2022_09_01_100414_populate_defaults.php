<?php

use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\Referenttype;
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
        $destinationType = Destinationtype::make();
        $destinationType->name = Destinationtype::getDefaultName();
        $destinationType->save();

        $referentType = Referenttype::make();
        $referentType->name = Referenttype::getDefaultName();
        $referentType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Destinationtype::truncate();
        Referenttype::truncate();

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
