<?php

namespace IlBronza\Clients\Tests\Feature;

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\Referenttype;
use IlBronza\Clients\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InstallationTest extends TestCase
{
    public function test_all_configured_package_classes_exist() : void
    {
        $check = function (array $configuration) use (&$check) {
            foreach ($configuration as $value) {
                if (is_array($value)) {
                    $check($value);
                } elseif (is_string($value) && str_starts_with($value, 'IlBronza\\Clients\\')) {
                    $this->assertTrue(class_exists($value), $value);
                }
            }
        };
        $check(config('clients'));
    }

    public function test_seed_rollback_preserves_custom_and_referenced_types() : void
    {
        $destination = $this->createClient()->createDestination();
        $destination->setAsDefault();
        Destinationtype::create(['name' => 'Custom']);
        Referenttype::create(['name' => 'Custom']);
        $migration = require dirname(__DIR__, 2) . '/database/migrations/2022_09_01_100414_populate_defaults.php';
        $migration->up();
        $migration->down();
        $this->assertTrue($destination->isDefault());
        $this->assertDatabaseHas('clients__destinationtypes', ['name' => 'Custom']);
        $this->assertDatabaseHas('clients__referenttypes', ['name' => 'Custom']);
        $this->assertDatabaseCount('clients__destinationtypes', 2);
    }

    public function test_package_migrations_can_be_rolled_back_and_use_custom_table_names() : void
    {
        $files = glob(dirname(__DIR__, 2) . '/database/migrations/*.php');
        foreach (array_reverse($files) as $file) {
            (require $file)->down();
        }
        $this->assertFalse(Schema::hasTable('clients__clients'));

        foreach (config('clients.models') as $name => $model) {
            config(["clients.models.{$name}.table" => 'custom_' . $model['table']]);
        }
        foreach ($files as $file) {
            (require $file)->up();
        }
        $this->assertTrue(Schema::hasColumn('custom_clients__clients', 'sdi'));
        $client = $this->createClient();
        $this->assertSame('custom_clients__clients', $client->getTable());
        $destination = $client->createDestination();
        $destination->setAsDefault();
        $this->assertTrue($client->fresh()->getDestination()->is($destination));
    }
}
