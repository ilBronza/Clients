<?php

namespace IlBronza\Clients\Tests;

use IlBronza\Clients\ClientsServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getApplicationBasePath()
    {
        $path = __DIR__ . '/.runtime/app';
        if (! is_dir($path)) {
            (new \Illuminate\Filesystem\Filesystem)->copyDirectory(parent::getApplicationBasePath(), $path);
        }
        foreach (['bootstrap/cache', 'storage/framework/views', 'storage/framework/cache', 'storage/logs'] as $directory) {
            if (! is_dir($path . '/' . $directory)) {
                mkdir($path . '/' . $directory, 0777, true);
            }
        }
        return $path;
    }

    protected function getPackageProviders($app)
    {
        return [
            \Spatie\Permission\PermissionServiceProvider::class,
            \Spatie\MediaLibrary\MediaLibraryServiceProvider::class,
            \IlBronza\AccountManager\AccountManagerServiceProvider::class,
            \IlBronza\Ukn\UknServiceProvider::class,
            \IlBronza\Menu\MenuServiceProvider::class,
            \IlBronza\UikitTemplate\UikitTemplateServiceProvider::class,
            \IlBronza\Buttons\ButtonsServiceProvider::class,
            \IlBronza\FormField\FormFieldServiceProvider::class,
            \IlBronza\Form\FormServiceProvider::class,
            \IlBronza\Datatables\DatatablesServiceProvider::class,
            \IlBronza\CRUD\CRUDServiceProvider::class,
            ClientsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('view.compiled', $app->storagePath('framework/views'));
        $app['config']->set('app.key', 'base64:' . base64_encode(str_repeat('c', 32)));
        $app['config']->set('app.locale', 'it');
        $app['config']->set('app.template', \IlBronza\UikitTemplate\UikitTemplate::class);
        $app['config']->set('menu.childrenPerColumn', 8);
        $app['config']->set('menu.serviceProviders', []);
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => true,
        ]);
        $app['config']->set('auth.providers.users.model', \IlBronza\AccountManager\Models\User::class);
        $app['config']->set('activitylog.enabled', false);
        $app['config']->set('activitylog.default_auth_driver', null);
        $app['config']->set('broadcasting.default', 'null');
        $app['config']->set('media-library.media_model', \IlBronza\CRUD\Models\Media::class);
        $app['config']->set('media-library.queue_conversions_by_default', false);
        $app['config']->set('addresses.models.address.table', 'addresses');
        $app['config']->set('addresses.models.address.class', \IlBronza\Addresses\Models\Address::class);
        $app['config']->set('addresses.default_type', 'default');
        $app['config']->set('operators.models.operator.table', 'operators');
        $app['config']->set('products.models.supplier.table', 'products_suppliers');
        $app['config']->set('products.models.supplier.class', \IlBronza\Products\Models\Sellables\Supplier::class);
        $app['config']->set('category.models.category.table', 'categories');
        $app['config']->set('category.models.category.class', \IlBronza\Category\Models\Category::class);
        $app['config']->set('category.models.categorizable.class', \IlBronza\Category\Models\Categorizable::class);
        $app['config']->set('category.models.categorizable.table', 'categorizables');
    }

    protected function setUp() : void
    {
        parent::setUp();

        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->nullableUuidMorphs('addressable');
            $table->string('type')->nullable();
            foreach (['street', 'number', 'zip', 'town', 'city', 'province', 'region', 'state'] as $field) {
                $table->string($field)->nullable();
            }
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('operators', fn (Blueprint $table) => $table->uuid('id')->primary());
        Schema::create('categories', fn (Blueprint $table) => $table->uuid('id')->primary());
        Schema::create('products_suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('target');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        Schema::create('users__userdata', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        foreach ([
            [\Spatie\Permission\PermissionServiceProvider::class, 'create_permission_tables'],
            [\Spatie\MediaLibrary\MediaLibraryServiceProvider::class, 'create_media_table'],
        ] as [$provider, $migration]) {
            $root = dirname((new \ReflectionClass($provider))->getFileName(), 2);
            (require $root . '/database/migrations/' . $migration . '.php.stub')->up();
        }

        foreach (glob(dirname(__DIR__) . '/database/migrations/*.php') as $file) {
            (require $file)->up();
        }
        Schema::table('media', fn (Blueprint $table) => $table->softDeletes());
    }

    protected function createClient(string $name = 'Acme') : \IlBronza\Clients\Models\Client
    {
        $client = new \IlBronza\Clients\Models\Client;
        $client->name = $name;
        $client->save();
        return $client;
    }

    protected function signIn(string $role = 'administrator') : \IlBronza\AccountManager\Models\User
    {
        $user = \IlBronza\AccountManager\Models\User::create([
            'name' => 'Tester', 'email' => uniqid() . '@example.com', 'password' => 'secret', 'active' => true,
        ]);
        $user->assignRole(\Spatie\Permission\Models\Role::findOrCreate($role, 'web'));
        $this->actingAs($user);
        return $user;
    }
}
