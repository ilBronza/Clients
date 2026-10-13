<?php

namespace IlBronza\Clients\Tests\Feature;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\Clients\Http\Controllers\Clients\ClientAsClientIndexController;
use IlBronza\Clients\Http\Controllers\Clients\ClientAsSupplierIndexController;
use IlBronza\Clients\Http\Controllers\Clients\ClientIndexController;
use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\ClientAsClient;
use IlBronza\Clients\Models\ClientAsSupplier;
use IlBronza\Clients\Tests\TestCase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClientIndexCacheTest extends TestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        config([
            'cache.default' => 'array',
            'cache.stores.array.serialize' => true,
            'contacts.models.contact.class' => \IlBronza\Contacts\Models\Contact::class,
            'contacts.models.contact.table' => 'contacts',
        ]);

        Schema::table('categories', fn (Blueprint $table) => $table->softDeletes());
        Schema::create('categorizables', function (Blueprint $table) {
            $table->uuid('category_id');
            $table->uuidMorphs('categorizable');
        });
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->uuidMorphs('contactable');
            $table->string('contact')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('index_cache_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function test_index_reuses_the_cached_query_and_its_loaded_relations() : void
    {
        $client = $this->createClient();
        $controller = new ClientIndexController;
        $first = $controller->getIndexElements();

        session(['clientModel' => new class {
            public function getFullNameForLogo() : string
            {
                return 'Acme';
            }
        }]);
        DB::enableQueryLog();
        DB::flushQueryLog();
        $cached = $controller->getIndexElements();

        $this->assertSame([], DB::getQueryLog());
        $this->assertFalse(session()->has('clientModel'));
        $this->assertSame([$client->getKey()], $cached->modelKeys());
        $this->assertSame($first->modelKeys(), $cached->modelKeys());
        foreach (['categories', 'defaultDestination', 'referents', 'contacts', 'address'] as $relation) {
            $this->assertTrue($cached->first()->relationLoaded($relation));
        }

        $this->travel(3601)->seconds();
        DB::flushQueryLog();
        $this->assertSame([$client->getKey()], $controller->getIndexElements()->modelKeys());
        $this->assertNotEmpty(DB::getQueryLog());
    }

    public function test_creating_a_client_invalidates_an_empty_index() : void
    {
        $controller = new ClientIndexController;
        $this->assertCount(0, $controller->getIndexElements());

        $client = $this->createClient();

        $this->assertFalse(cache()->has(Client::getIndexCacheKey()));
        $this->assertSame([$client->getKey()], $controller->getIndexElements()->modelKeys());
    }

    public function test_saving_a_client_refreshes_all_client_and_supplier_indexes() : void
    {
        $client = $this->createClient();
        $client->is_client = true;
        $client->is_supplier = true;
        $client->save();

        $index = new ClientIndexController;
        $asClient = new ClientAsClientIndexController;
        $asSupplier = new ClientAsSupplierIndexController;
        foreach ([$index, $asClient, $asSupplier] as $controller) {
            $this->assertSame([$client->getKey()], $controller->getIndexElements()->modelKeys());
        }

        $client->name = 'Updated';
        $client->is_supplier = false;
        $client->save();

        foreach ([Client::class, ClientAsClient::class, ClientAsSupplier::class] as $modelClass) {
            $this->assertFalse(cache()->has($modelClass::getIndexCacheKey()));
        }
        $this->assertSame('Updated', $index->getIndexElements()->first()->name);
        $this->assertSame('Updated', $asClient->getIndexElements()->first()->name);
        $this->assertCount(0, $asSupplier->getIndexElements());

        $alias = ClientAsClient::findOrFail($client->getKey());
        $alias->name = 'Saved through alias';
        $alias->save();
        $this->assertSame('Saved through alias', $index->getIndexElements()->first()->name);
    }

    public function test_deleting_a_client_removes_it_from_the_cached_index() : void
    {
        $client = $this->createClient();
        $controller = new ClientIndexController;
        $this->assertCount(1, $controller->getIndexElements());

        $client->delete();

        $this->assertFalse(cache()->has(Client::getIndexCacheKey()));
        $this->assertCount(0, $controller->getIndexElements());
    }

    public function test_area_managers_cannot_read_or_populate_the_shared_cache() : void
    {
        $client = $this->createClient();
        $controller = new ClientIndexController;
        $this->assertSame([$client->getKey()], $controller->getIndexElements()->modelKeys());

        $this->signIn('areaManager');
        $this->assertCount(0, $controller->getIndexElements());
        $this->assertTrue(cache()->has(Client::getIndexCacheKey()));

        Client::forgetIndexCache();
        $this->assertCount(0, $controller->getIndexElements());
        $this->assertFalse(cache()->has(Client::getIndexCacheKey()));

        $this->signIn('administrator');
        $this->assertSame([$client->getKey()], $controller->getIndexElements()->modelKeys());
    }

    public function test_base_model_invalidates_its_own_index_during_saving() : void
    {
        $controller = new ClientIndexController;
        $controller->getIndexElements();
        $model = new IndexCacheModel;
        cache()->put(IndexCacheModel::getIndexCacheKey(), 'stale', 3600);
        cache()->put('unrelated-cache', 'keep', 3600);

        IndexCacheModel::saving(function () {
            $this->assertFalse(cache()->has(IndexCacheModel::getIndexCacheKey()));
        });
        $model->name = 'Created';
        $model->save();

        cache()->put(IndexCacheModel::getIndexCacheKey(), 'stale again', 3600);
        $model->name = 'Updated';
        $model->save();

        $this->assertTrue(cache()->has(Client::getIndexCacheKey()));
        $this->assertSame('keep', cache()->get('unrelated-cache'));
    }
}

class IndexCacheModel extends BaseModel
{
    protected $table = 'index_cache_models';
}
