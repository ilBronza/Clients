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
        // Seed rows may predate this migration or be referenced by user data.
        // Leave them in place; the table migrations handle a full rollback.
    }
};
