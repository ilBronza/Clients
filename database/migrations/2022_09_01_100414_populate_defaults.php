<?php

use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\Referenttype;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table(config('clients.models.destinationtype.table'))->insertOrIgnore([
            'name' => Destinationtype::getDefaultName(),
            'slug' => Destinationtype::getDefaultName(),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table(config('clients.models.referenttype.table'))->insertOrIgnore([
            'name' => Referenttype::getDefaultName(),
            'slug' => Referenttype::getDefaultName(),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Destinationtype::truncate();
        Referenttype::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
